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
     * Set the order id.
     *
     * @param  string  $id
     * @return $this
     */
    public function setOrderId(string $id)
    {
        $this->attributes['order_id'] = $id;

        return $this;
    }

    /**
     * Get the order id.
     *
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->attributes['order_id'];
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

    /**
     * Set the name.
     *
     * @param  string  $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->attributes['name'] = $name;

        return $this;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Set the sku.
     *
     * @param  string  $sku
     * @return $this
     */
    public function setSku(string $sku)
    {
        $this->attributes['sku'] = $sku;

        return $this;
    }

    /**
     * Get the sku.
     *
     * @return string
     */
    public function getSku(): string
    {
        return $this->attributes['sku'];
    }
}
