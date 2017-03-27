<?php

namespace WTG\Checkout\Controllers;

use WTG\Checkout\Requests\DeleteProductRequest;
use WTG\Checkout\Requests\EditProductRequest;
use WTG\Checkout\Requests\AddProductRequest;
use Illuminate\Routing\Controller;
use WTG\Catalog\Models\Product;
use WTG\Checkout\Models\Quote;

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
     * Add a product to the cart.
     *
     * @param  AddProductRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(AddProductRequest $request)
    {
        $quote = $this->getActiveQuote();
        $product = Product::find($request->input('product'));

        if ($quote->addProduct($product, $request->input('quantity'))) {
            return back()
                ->with('status', trans('checkout::cart.item_add_success'));
        }

        return back()
            ->withErrors(trans('checkout::cart.item_add_error'));
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
        dd($request->input('products'));

        $product = Product::find();
        if ($product === null) {
            return back();
        }

        if ($quote->editProduct($product, ['quantity' => $request->input('quantity')])) {
            return back()
                ->with('status', trans('checkout::cart.item_update_success'));
        }

        return back()
            ->withErrors(trans('checkout::cart.item_update_error'));
    }

    /**
     * Remove an item from the cart.
     *
     * @param  DeleteProductRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(DeleteProductRequest $request)
    {
        $quote = $this->getActiveQuote();
        $product = Product::find($request->input('product'));

        if ($quote->removeProduct($product)) {
            return back()
                ->with('status', trans('checkout::cart.item_remove_success'));
        }

        return back()
            ->withErrors(trans('checkout::cart.item_remove_error'));
    }

    /**
     * Destroy the cart.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        $quote = $this->getActiveQuote();

        if ($quote->delete()) {
            return back()
                ->with('status', trans('checkout::cart.destroy_success'));
        }

        return back()
            ->withErrors(trans('checkout::cart.destroy_error'));
    }

    /**
     * Get the active quote.
     *
     * @return \WTG\Checkout\Models\Quote
     */
    protected function getActiveQuote()
    {
        return Quote::findQuoteByUser(\Auth::user());
    }
}