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
     * Get the quote item id.
     *
     * @return int
     */
    public function getId();

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
     * @param  int  $productId
     * @return $this
     */
    public function setProductId(int $productId);
}