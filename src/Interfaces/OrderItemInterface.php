<?php

namespace WTG\Checkout\Interfaces;

/**
 * Order item interface
 *
 * @package     WTG\Checkout
 * @subpackage  Interfaces
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
interface OrderItemInterface
{
    /**
     * Set the order item id
     *
     * @param  string  $id
     * @return $this
     */
    public function setId(string $id);

    /**
     * Get the quote item id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set the order id.
     *
     * @param  string  $id
     * @return $this
     */
    public function setOrderId(string $id);

    /**
     * Get the order id.
     *
     * @return string
     */
    public function getOrderId(): string;

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
}