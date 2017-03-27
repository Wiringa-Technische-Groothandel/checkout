<?php

namespace WTG\Checkout\Models;

use WTG\Checkout\Interfaces\QuoteItemInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class QuoteItem extends Model implements QuoteItemInterface
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
    public function quote()
    {
        return $this->belongsTo(Quote::class);
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
