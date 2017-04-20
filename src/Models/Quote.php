<?php

namespace WTG\Checkout\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use WTG\Checkout\Interfaces\OrderInterface;
use WTG\Checkout\Interfaces\QuoteInterface;
use Illuminate\Database\Eloquent\Collection;
use WTG\Checkout\Interfaces\QuoteItemInterface;
use WTG\Checkout\Exceptions\QuoteItemNotFoundException;

/**
 * Class Quote
 *
 * @package     WTG\Checkout
 * @subpackage  Models
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class Quote extends Model implements QuoteInterface
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * Customer scope
     *
     * @param  Builder  $query
     * @param  string  $customerId
     * @return Builder
     */
    public function scopeCustomer(Builder $query, string $customerId): Builder
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Get a quote by the user, or create a new one if the user
     * does not have an active quote
     *
     * @param  string  $customerId
     * @return QuoteInterface
     */
    public static function findQuoteByCustomerId(string $customerId): QuoteInterface
    {
        $quote = app()->make(QuoteInterface::class)
            ->customer($customerId)
            ->first();

        if ($quote === null) {
            $quote = app()->make(QuoteInterface::class);
            $quote->setId(Uuid::generate(4));
            $quote->setCustomerId($customerId);
            $quote->save();
        }

        return $quote;
    }

    /**
     * Get the quote id
     *
     * @param  string  $id
     * @return $this
     */
    public function setId(string $id)
    {
        $this->attributes['id'] = $id;

        return $this;
    }

    /**
     * Get the quote id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Set the customer id.
     *
     * @param  string  $id
     * @return $this
     */
    public function setCustomerId(string $id)
    {
        $this->attributes['customer_id'] = $id;

        return $this;
    }

    /**
     * Get the customer id.
     *
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->attributes['customer_id'];
    }

    /**
     * Set the company id.
     *
     * @param  string  $id
     * @return $this
     */
    public function setCompanyId(string $id)
    {
        $this->attributes['company_id'] = $id;

        return $this;
    }

    /**
     * Get the company id.
     *
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->attributes['company_id'];
    }

    /**
     * Add a product to the quote or modify if it exists.
     *
     * @param  string  $productId
     * @param  float  $quantity
     * @param  string  $sku
     * @param  string  $name
     * @param  float  $price
     * @param  float  $subtotal
     * @return bool
     */
    public function addProduct(string $productId, float $quantity = 1.00, string $sku, string $name, float $price, float $subtotal): bool
    {
        if ($quantity <= 0.00) {
            return $this->removeProduct($productId);
        }

        try {
            $quoteItem = $this->getQuoteItemByProductId($productId);
        } catch (QuoteItemNotFoundException $e) {
            $quoteItem = app()->make(QuoteItemInterface::class);
            $quoteItem->setId(Uuid::generate(4));
            $quoteItem->setQuoteId($this->getId());
            $quoteItem->setProductId($productId);
            $quoteItem->setName($name);
            $quoteItem->setSku($sku);
            $quoteItem->setPrice($price);
            $quoteItem->setSubtotal($subtotal);
        }

        $quoteItem->setQuantity($quantity);

        return $quoteItem->save();
    }

    /**
     * Edit a quote item
     *
     * @param  string  $productId
     * @param  array  $options
     * @return bool
     *
     * TODO: Use the quote item id
     */
    public function editProduct(string $productId, array $options): bool
    {
        $quoteItem = $this->getQuoteItemByProductId($productId);
        $quoteItem->fill($options);

        return $quoteItem->save();
    }

    /**
     * Remove the product from the quote
     *
     * @param  string  $productId
     * @return bool
     */
    public function removeProduct(string $productId): bool
    {
        $quoteItem = $this->getQuoteItemByProductId($productId);

        if ($quoteItem === null) {
            // Return in success as apparently there is no quote item associated with
            // the given product id (anymore).
            return true;
        }

        return (bool) $quoteItem->delete();
    }

    /**
     * Get the grand total
     *
     * @return float
     */
    public function getGrandTotal(): float
    {
        return $this->getItems()->sum(function ($item) {
            return $item->getSubtotal();
        });
    }

    /**
     * Get the associated items
     *
     * @return Collection
     */
    public function getItems(): Collection
    {
        return app()->make(QuoteItemInterface::class)
            ->where('quote_id', $this->getId())
            ->get();
    }

    /**
     * Count the number of items that are in the quote.
     *
     * @return int
     */
    public function getItemCount(): int
    {
        return $this->getItems()->count();
    }

    /**
     * Turn the quote into an order
     *
     * @return OrderInterface
     */
    public function toOrder(): OrderInterface
    {
        $order = app()->make(OrderInterface::class);
        $order->setId(Uuid::generate(4));
        $order->setCustomerId(\Auth::id());
        $order->setGrandTotal($this->getGrandTotal(true));
        $order->save();

        return $order;
    }

    /**
     * Get a related quote item by its product id
     *
     * @param  string  $productId
     * @return QuoteItem
     * @throws QuoteItemNotFoundException
     */
    protected function getQuoteItemByProductId(string $productId)
    {
        $quoteItem = app()->make(QuoteItemInterface::class)
            ->where('quote_id', $this->getId())
            ->where('product_id', $productId)
            ->first();

        if ($quoteItem === null) {
            throw new QuoteItemNotFoundException;
        }

         return $quoteItem;
    }
}
