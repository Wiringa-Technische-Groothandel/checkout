<?php

namespace WTG\Checkout\Controllers;

use WTG\Catalog\Interfaces\ProductInterface;
use WTG\Checkout\Interfaces\QuoteItemInterface;
use WTG\Checkout\Models\Quote;
use WTG\Catalog\Models\Product;
use Illuminate\Routing\Controller;
use WTG\Checkout\Interfaces\QuoteInterface;
use WTG\Checkout\Requests\AddProductRequest;
use WTG\Checkout\Requests\EditProductRequest;
use WTG\Checkout\Requests\DeleteProductRequest;
use WTG\Checkout\Requests\UpdateProductRequest;

/**
 * Cart controller
 *
 * @package     WTG\Checkout
 * @subpackage  Controllers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class CartController extends Controller
{
    /**
     * @var QuoteInterface
     */
    protected $quote;

    /**
     * Add a product to the cart.
     *
     * @param  AddProductRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(AddProductRequest $request)
    {
        $quote = $this->getActiveQuote();
        $product = app()->make(ProductInterface::class)
            ->find($request->input('product'));

        if ($quote->addProduct($product->getId(), $request->input('quantity'))) {
            return response([
                'success' => true,
                'message' => trans('checkout::cart.item_add_success'),
                'count' => $quote->getItemCount()
            ]);
        }

        return response([
            'success' => false,
            'message' => trans('checkout::cart.item_add_error')
        ], 400);
    }

    /**
     * Edit an item in the cart.
     *
     * @param  EditProductRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(EditProductRequest $request)
    {
        $quote = $this->getActiveQuote();
        $products = $request->input('products');

        try {
            $quote->getItems()->each(function ($item) use ($products) {
                $qty = $products[$item->getId()]['qty'] ?? 0;
                $item->setQuantity($qty);
                $item->save();
            });
        } catch (\Exception $e) {
            \Log::error($e->getMessage(), $e->getTrace());

            return back()
                ->withErrors(trans('checkout::cart.item_update_error'));
        }

        return back()
            ->with('status', trans('checkout::cart.item_update_success'));
    }

    /**
     * Remove an item from the cart.
     *
     * @param  string  $itemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(string $itemId)
    {
        $quote = $this->getActiveQuote();
        /** @var QuoteItemInterface $quoteItem */
        $quoteItem = $quote->getItems()->first(function ($item) use ($itemId) {
            return $item->getId() === $itemId;
        });

        if ($quoteItem->delete()) {
            return response([
                'success' => true,
                'message' => trans('checkout::cart.item_remove_success'),
                'count' => $quote->getItemCount()
            ]);
        }

        return response([
            'success' => false,
            'message' => trans('checkout::cart.item_remove_error')
        ], 400);
    }

    /**
     * Update a single item.
     *
     * @param  UpdateProductRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $quote = $this->getActiveQuote();
        $qty = $request->input('quantity');
        /** @var QuoteItemInterface $quoteItem */
        $quoteItem = $quote->getItems()->first(function ($item) use ($id) {
            return $item->getId() === $id;
        });

        if ($quoteItem === null) {
            return response([
                'success' => false,
                'message' => 'Onbekend id opgegeven'
            ], 400);
        }

        /** @var ProductInterface $product */
        $product = app()->make(ProductInterface::class)
            ->find($quoteItem->getProductId());

        if ($product === null) {
            $quoteItem->delete();

            return response([
                'success' => false,
                'message' => 'Het product is verwijderd uit uw winkelmandje omdat het product niet (meer) in ons assortiment zit.'
            ]);
        }

        $quoteItem->setQuantity((int) $qty);
        $quoteItem->save();

        return response([
            'success' => true,
            'subtotal' => app('format')->price(
                $product->getPrice(true, $quoteItem->getQuantity())
            ),
            'total' => app('format')->price($quote->getGrandTotal(true)),
            'quantity' => (int) $qty
        ]);
    }

    /**
     * Destroy the cart.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        $quote = $this->getActiveQuote();
        $quote->getItems()->each(function ($item) {
            $item->delete();
        });

        if ($quote->delete()) {
            return response([
                'success' => true
            ]);
        }

        return response([
            'success' => false,
            'message' => trans('checkout::cart.destroy_error')
        ], 400);
    }

    /**
     * Get the active quote.
     *
     * @return \WTG\Checkout\Interfaces\QuoteInterface
     */
    protected function getActiveQuote()
    {
        if ($this->quote !== null) {
            return $this->quote;
        }

        $this->quote = Quote::findQuoteByCustomerId(\Auth::id(), \Auth::user()->getCompanyId());

        return $this->quote;
    }
}