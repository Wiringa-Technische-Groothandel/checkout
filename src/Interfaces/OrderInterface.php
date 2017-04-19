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
     * Get orders by the company id.
     *
     * @param  string  $companyId
     * @return Builder
     */
    public static function getByCompanyId(string $companyId): Builder;

    /**
     * @param  string  $customerId
     * @return Builder
     */
    public function getByCustomerId(string $customerId): Builder;

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
     * Set the company id.
     *
     * @param  int  $id
     * @return $this
     */
    public function setCompanyId(int $id);

    /**
     * Get the company id.
     *
     * @return string
     */
    public function getCompanyId(): string;

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