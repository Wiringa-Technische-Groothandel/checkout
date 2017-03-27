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
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The quote this item belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * The product this quote item is referencing
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the quote item id
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

    /**
     * Get the attached product.
     *
     * @return Product|null
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set the product id.
     *
     * @param  int  $productId
     * @return $this
     */
    public function setProductId(int $productId)
    {
        $this->attributes['product_id'] = $productId;

        return $this;
    }
}
