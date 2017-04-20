<?php

namespace WTG\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use WTG\Checkout\Interfaces\OrderInterface;
use WTG\Checkout\Interfaces\OrderItemInterface;

/**
 * Order model
 *
 * @package     WTG\Checkout
 * @subpackage  Models
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class Order extends Model implements OrderInterface
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @param  string  $companyId
     * @return Builder
     */
    public static function getByCompanyId(string $companyId): Builder
    {
        return static::where('company_id', $companyId);
    }

    /**
     * @param  string  $customerId
     * @return Builder
     */
    public function getByCustomerId(string $customerId): Builder
    {
        return static::where('customer_id', $customerId);
    }

    /**
     * Set the order id
     *
     * @param  string  $id
     * @return $this
     */
    public function setId(string $id)
    {
        $this->attributes['id'] = $id;

        return $this;
    }

    /**
     * Get the order id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Set the customer id.
     *
     * @param  int  $id
     * @return $this
     */
    public function setCustomerId(int $id)
    {
        $this->attributes['customer_id'] = $id;

        return $this;
    }

    /**
     * Get the customer id.
     *
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->attributes['customer_id'];
    }

    /**
     * Set the grand total
     *
     * @param  float  $grandTotal
     * @return $this
     */
    public function setGrandTotal(float $grandTotal)
    {
        $this->attributes['grand_total'] = $grandTotal;

        return $this;
    }
}