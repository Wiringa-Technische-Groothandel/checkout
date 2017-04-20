<?php

namespace WTG\Checkout\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use WTG\Checkout\Interfaces\QuoteInterface;
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
     * Get the parent quote.
     *
     * @return QuoteInterface
     */
    public function getQuote(): QuoteInterface
    {
        return app()->make(QuoteInterface::class)
            ->find($this->getQuoteId());
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
    public function getQuantity(): float
    {
        return $this->attributes['quantity'];
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

    /**
     * Set the quote id.
     *
     * @param  string  $id
     * @return $this
     */
    public function setQuoteId(string $id)
    {
        $this->attributes['quote_id'] = $id;

        return $this;
    }

    /**
     * Get the quote id.
     *
     * @return string
     */
    public function getQuoteId(): string
    {
        return $this->attributes['quote_id'];
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

    /**
     * Set the price.
     *
     * @param  float  $price
     * @return $this
     */
    public function setPrice(float $price)
    {
        $this->attributes['price'] = $price;

        return $this;
    }

    /**
     * Get the price.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->attributes['price'];
    }

    /**
     * Set the subtotal.
     *
     * @param  float  $subtotal
     * @return $this
     */
    public function setSubtotal(float $subtotal)
    {
        $this->attributes['subtotal'] = $subtotal;

        return $this;
    }

    /**
     * Get the subtotal.
     *
     * @return float
     */
    public function getSubtotal(): float
    {
        return $this->attributes['subtotal'];
    }

    /**
     * Get the created at time.
     *
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return Carbon::parse($this->attributes['created_at']);
    }

    /**
     * Get the updated at time.
     *
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return Carbon::parse($this->attributes['updated_at']);
    }
}
