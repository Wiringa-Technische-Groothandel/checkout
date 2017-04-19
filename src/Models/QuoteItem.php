<?php

namespace WTG\Checkout\Models;

use Illuminate\Database\Eloquent\Model;
use WTG\Checkout\Interfaces\QuoteInterface;
use WTG\Catalog\Interfaces\ProductInterface;
use WTG\Checkout\Interfaces\QuoteItemInterface;

/**
 * Quote item model
 *
 * @package     WTG\Checkout
 * @subpackage  Models
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class QuoteItem extends Model implements QuoteItemInterface
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
     * The quote this item belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function quote()
    {
        return $this->belongsTo(app()->make(QuoteInterface::class));
    }

    /**
     * The product this quote item is referencing
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function product()
    {
        return $this->belongsTo(app()->make(ProductInterface::class));
    }

    /**
     * Set the quote item id.
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
     * Get the quote item id.
     *
     * @return string
     */
    public function getId(): string
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
     * @return ProductInterface|null
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set the product id.
     *
     * @param  string  $productId
     * @return $this
     */
    public function setProductId(string $productId)
    {
        $this->attributes['product_id'] = $productId;

        return $this;
    }

    /**
     * Get the product id.
     *
     * @return string
     */
    public function getProductId(): string
    {
        return $this->attributes['product_id'];
    }
}
