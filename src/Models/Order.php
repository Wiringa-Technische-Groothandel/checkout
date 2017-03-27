<?php

namespace WTG\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use WTG\Checkout\Interfaces\OrderInterface;

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
     * The order items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the order id
     *
     * @return int
     */
    public function getId(): int
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