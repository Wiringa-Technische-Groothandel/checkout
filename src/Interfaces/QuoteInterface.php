<?php

namespace WTG\Checkout\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Quote interface
 *
 * @package     WTG\Checkout
 * @subpackage  Interfaces
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
interface QuoteInterface
{
    /**
     * Customer scope
     *
     * @param  Builder  $query
     * @param  string  $customerId
     * @return Builder
     */
    public function scopeCustomer(Builder $query, string $customerId): Builder;

    /**
     * Get a quote by the user, or create a new one if the user
     * does not have an active quote
     *
     * @param  string  $customerId
     * @return QuoteInterface
     */
    public static function findQuoteByCustomerId(string $customerId): QuoteInterface;

    /**
     * Get the quote id
     *
     * @param  string  $id
     * @return $this
     */
    public function setId(string $id);

    /**
     * Get the quote id.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set the customer id.
     *
     * @param  string  $id
     * @return $this
     */
    public function setCustomerId(string $id);

    /**
     * Get the customer id.
     *
     * @return string
     */
    public function getCustomerId(): string;

    /**
     * Set the company id.
     *
     * @param  string  $id
     * @return $this
     */
    public function setCompanyId(string $id);

    /**
     * Get the company id.
     *
     * @return string
     */
    public function getCompanyId(): string;

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
    public function addProduct(string $productId, float $quantity = 1.00, string $sku, string $name, float $price, float $subtotal): bool;

    /**
     * Edit a quote item.
     *
     * @param  string  $productId
     * @param  array  $options
     * @return bool
     */
    public function editProduct(string $productId, array $options): bool;

    /**
     * Remove a product from the quote.
     *
     * @param  string  $productId
     * @return bool
     */
    public function removeProduct(string $productId): bool;

    /**
     * Get the sum of the price of all quote items.
     *
     * @return float
     */
    public function getGrandTotal(): float;

    /**
     * Get the associated items
     *
     * @return Collection
     */
    public function getItems(): Collection;

    /**
     * Get the number of items in the quote.
     *
     * @return int
     */
    public function getItemCount(): int;

    /**
     * Turn a quote into an order
     *
     * @return OrderInterface
     */
    public function toOrder(): OrderInterface;
}