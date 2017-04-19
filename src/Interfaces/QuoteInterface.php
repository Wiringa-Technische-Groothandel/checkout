<?php

namespace WTG\Checkout\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use WTG\Customer\Interfaces\CustomerInterface;

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
     * Get a quote by the user, or create a new one if the user has not active quote
     *
     * @param  string  $customerId
     * @param  string  $companyId
     * @return QuoteInterface
     */
    public static function findQuoteByCustomerId(string $customerId, string $companyId): QuoteInterface;

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
     * @return bool|Model
     */
    public function addProduct(string $productId, float $quantity = 1.00);

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
     * @param  bool  $withDiscount
     * @return float
     */
    public function getGrandTotal(bool $withDiscount): float;

    /**
     * Get the associated items
     *
     * @return Collection
     */
    public function getItems(): Collection;

    /**
     * Get the customer
     *
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface;

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