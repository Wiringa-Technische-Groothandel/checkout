<?php

namespace WTG\Checkout\Models;

use Illuminate\Database\Eloquent\Collection;
use WTG\Catalog\Interfaces\ProductInterface;
use WTG\Checkout\Exceptions\QuoteItemNotFoundException;
use WTG\Checkout\Interfaces\QuoteItemInterface;
use WTG\Customer\Interfaces\CustomerInterface;
use WTG\Checkout\Interfaces\OrderInterface;
use WTG\Checkout\Interfaces\QuoteInterface;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

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
     * Get a quote by the user, or create a new one if the user has not active quote
     *
     * @param  string  $customerId
     * @param  string  $companyId
     * @return QuoteInterface
     */
    public static function findQuoteByCustomerId(string $customerId, string $companyId): QuoteInterface
    {
        $quote = app()->make(QuoteInterface::class)
            ->where('customer_id', $customerId)
            ->where('company_id', $companyId)
            ->first();

        if ($quote === null) {
            $quote = new static;
            $quote->setId(Uuid::generate(4));
            $quote->setCustomerId($customerId);
            $quote->setCompanyId($companyId);
            $quote->save();
        }

        return $quote;
    }

    /**
     * The items in this quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function items()
    {
        return $this->hasMany(app()->make(QuoteItemInterface::class));
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
     * Add a product to the quote or modify it if product exists
     *
     * @param  string  $productId
     * @param  float  $quantity
     * @return bool|Model
     */
    public function addProduct(string $productId, float $quantity = 1.00)
    {
        if ($quantity <= 0.00) {
            return $this->removeProduct($productId);
        }

        try {
            $quoteItem = $this->getQuoteItemByProductId($productId);
        } catch (QuoteItemNotFoundException $e) {
            $quoteItem = app()->make(QuoteItemInterface::class);
            $quoteItem->setId(Uuid::generate(4));
            $quoteItem->setProductId($productId);
        }

        $quoteItem->setQuantity($quantity);

        return $this->items()->save($quoteItem);
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
            return false;
        }

        return (bool) $quoteItem->delete();
    }

    /**
     * Get the grand total
     *
     * @param  bool  $withDiscount
     * @return float
     */
    public function getGrandTotal(bool $withDiscount): float
    {
        return $this->getItems()->sum(function ($item) use ($withDiscount) {
            return (float) $item->getProduct()->getPrice(
                $withDiscount,
                $item->getQuantity()
            );
        });
    }

    /**
     * Get the associated items
     *
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * Get the customer
     *
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    /**
     * Count the number of items that are in the quote.
     *
     * @return int
     */
    public function getItemCount(): int
    {
        return $this->items()->count();
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
        $quoteItem = $this->items()->where('product_id', $productId)->first();

        if ($quoteItem === null) {
            throw new QuoteItemNotFoundException;
        }

         return $quoteItem;
    }
}
