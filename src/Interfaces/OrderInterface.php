<?php

namespace WTG\Checkout\Interfaces;

use Illuminate\Database\Eloquent\Builder;

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
     * Customer scope
     *
     * @param  Builder  $query
     * @param  string  $customerId
     * @return Builder
     */
    public function scopeCustomer(Builder $query, string $customerId): Builder;

    /**
     * Set the order id
     *
     * @param  string  $id
     * @return $this
     */
    public function setId(string $id);

    /**
     * Get the order id
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set the customer id.
     *
     * @param  int  $id
     * @return $this
     */
    public function setCustomerId(int $id);

    /**
     * Get the customer id.
     *
     * @return string
     */
    public function getCustomerId(): string;

    /**
     * Set the grand total
     *
     * @param  float  $grandTotal
     * @return $this
     */
    public function setGrandTotal(float $grandTotal);
}