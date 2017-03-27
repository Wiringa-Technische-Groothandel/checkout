<?php

namespace WTG\Checkout\Interfaces;

use WTG\Checkout\Models\Order;
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
     * Get a quote by the user, or create if the user does not have a quote.
     *
     * @param  CustomerInterface  $user
     * @return static
     */
    public static function findQuoteByUser(CustomerInterface $user);

    /**
     * Get the quote id.
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Add a product to the quote or modify if it exists.
     *
     * @param  CustomerInterface  $product
     * @param  float  $quantity
     * @return bool
     */
    public function addProduct(CustomerInterface $product, float $quantity = 1.00): bool;

    /**
     * Edit a quote item.
     *
     * @param  CustomerInterface  $product
     * @param  array  $options
     * @return bool
     */
    public function editProduct(CustomerInterface $product, array $options): bool;

    /**
     * Remove a product from the quote.
     *
     * @param  CustomerInterface  $product
     * @return bool
     */
    public function removeProduct(CustomerInterface $product): bool;

    /**
     * Get the sum of the price of all quote items.
     *
     * @param  bool  $withDiscount
     * @return float
     */
    public function getGrandTotal(bool $withDiscount): float;

    /**
     * Get the number of items in the quote.
     *
     * @return int
     */
    public function getItemCount(): int;

    /**
     * Turn a quote into an order
     *
     * @return Order
     */
    public function toOrder(): Order;
}