<?php

namespace WTG\Checkout\Interfaces;

use Carbon\Carbon;

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
     * Get the parent quote.
     *
     * @return QuoteInterface
     */
    public function getQuote(): QuoteInterface;

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
    public function getQuantity(): float;

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

    /**
     * Set the quote id.
     *
     * @param  string  $id
     * @return $this
     */
    public function setQuoteId(string $id);

    /**
     * Get the quote id.
     *
     * @return string
     */
    public function getQuoteId(): string;

    /**
     * Set the name.
     *
     * @param  string  $name
     * @return $this
     */
    public function setName(string $name);

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set the sku.
     *
     * @param  string  $sku
     * @return $this
     */
    public function setSku(string $sku);

    /**
     * Get the sku.
     *
     * @return string
     */
    public function getSku(): string;

    /**
     * Set the price.
     *
     * @param  float  $price
     * @return $this
     */
    public function setPrice(float $price);

    /**
     * Get the price.
     *
     * @return float
     */
    public function getPrice(): float;

    /**
     * Set the subtotal.
     *
     * @param  float  $subtotal
     * @return $this
     */
    public function setSubtotal(float $subtotal);

    /**
     * Get the subtotal.
     *
     * @return float
     */
    public function getSubtotal(): float;

    /**
     * Get the created at time.
     *
     * @return Carbon
     */
    public function getCreatedAt(): Carbon;

    /**
     * Get the updated at time.
     *
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon;
}