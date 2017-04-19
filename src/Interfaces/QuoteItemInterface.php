<?php

namespace WTG\Checkout\Interfaces;

/**
 * Quote item interface
 *
 * @package     WTG\Checkout
 * @subpackage  Interfaces
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
interface QuoteItemInterface
{
    /**
     * Set the quote item id.
     *
     * @return int
     */
    public function setId(string $id);

    /**
     * Get the quote item id.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set the quantity.
     *
     * @param  float  $quantity
     * @return $this
     */
    public function setQuantity(float $quantity = 1.00);

    /**
     * Get the quantity.
     *
     * @return float
     */
    public function getQuantity();

    /**
     * Set the product id.
     *
     * @param  string  $productId
     * @return $this
     */
    public function setProductId(string $productId);

    /**
     * Get the product id.
     *
     * @return string
     */
    public function getProductId(): string;
}