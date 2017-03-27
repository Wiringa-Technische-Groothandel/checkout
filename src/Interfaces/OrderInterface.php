<?php

namespace WTG\Checkout\Interfaces;

/**
 * Order interface
 *
 * @package     WTG\Checkout
 * @subpackage  Interfaces
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
interface OrderInterface
{
    /**
     * Get the quote id.
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Set the customer id
     *
     * @param  int  $id
     * @return $this
     */
    public function setCustomerId(int $id);

    /**
     * Set the grand total
     *
     * @param  float  $grandTotal
     * @return $this
     */
    public function setGrandTotal(float $grandTotal);
}