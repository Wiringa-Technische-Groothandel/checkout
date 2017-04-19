<?php

namespace WTG\Checkout\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use WTG\Checkout\Interfaces\OrderItemInterface;

/**
 * Order item model
 *
 * @package     WTG\Checkout
 * @subpackage  Models
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class OrderItem extends Model implements OrderItemInterface
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The order this item belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Set the order item id
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
     * Get the order item id
     *
     * @return int
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * Set the quantity
     *
     * @param  float  $quantity
     * @return $this
     */
    public function setQuantity(float $quantity = 1.00)
    {
        $this->attributes['quantity'] = $quantity;

        return $this;
    }

    /**
     * Get the quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->attributes['quantity'];
    }
}
