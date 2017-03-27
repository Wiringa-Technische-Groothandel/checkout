<?php

namespace WTG\Checkout\Models;

use WTG\Checkout\Exceptions\QuoteItemNotFoundException;
use WTG\Customer\Interfaces\CustomerInterface;
use WTG\Checkout\Interfaces\QuoteInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Quote extends Model implements QuoteInterface
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get a quote by the user, or create a new one if the user has not active quote
     *
     * @param  CustomerInterface  $user
     * @return static
     */
    public static function findQuoteByUser(CustomerInterface $user)
    {
        return static::firstOrCreate([
            'user_id' => $user->id
        ]);
    }

    /**
     * The user this quote belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The items in this quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    /**
     * Get the quote id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->attributes[$this->getKeyName()];
    }

    /**
     * Add a product to the quote or modify it if product exists
     *
     * @param  CustomerInterface  $product
     * @param  float  $quantity
     * @return bool
     */
    public function addProduct(CustomerInterface $product, float $quantity = 1.00): bool
    {
        if ($quantity <= 0.00) {
            return $this->removeProduct($product);
        }

        try {
            $quoteItem = $this->getQuoteItemByProduct($product);
        } catch (QuoteItemNotFoundException $e) {
            $quoteItem = new QuoteItem;
            $quoteItem->setProductId($product->getId());
        }

        $quoteItem->setQuantity($quantity);

        return $this->items()->save($quoteItem);
    }

    /**
     * Edit a quote item
     *
     * @param  CustomerInterface  $product
     * @param  array  $options
     * @return bool
     */
    public function editProduct(CustomerInterface $product, array $options): bool
    {
        $quoteItem = $this->getQuoteItemByProduct($product);
        $quoteItem->fill($options);

        return $quoteItem->save();
    }

    /**
     * Remove the product from the quote
     *
     * @param  CustomerInterface  $product
     * @return bool|null
     */
    public function removeProduct(CustomerInterface $product): bool
    {
        $quoteItem = $this->getQuoteItemByProduct($product);

        if ($quoteItem === null) {
            return false;
        }

        return (bool) $quoteItem->delete();
    }

    /**
     * Get the grand total
     *
     * @param  bool  $withDiscount
     * @return float
     */
    public function getGrandTotal(bool $withDiscount): float
    {
        return $this->items->sum(function ($item) use ($withDiscount) {
            return $item->product->getPrice(
                $withDiscount,
                $item->getQuantity()
            );
        });
    }

    /**
     * Count the number of items that are in the quote.
     *
     * @return int
     */
    public function getItemCount(): int
    {
        return $this->items()->count();
    }

    /**
     * Turn the quote into an order
     *
     * @return Order
     */
    public function toOrder(): Order
    {
        $order = new Order;
        $order->setCustomerId(\Auth::id());
        $order->setGrandTotal($this->getGrandTotal(true));
    }

    /**
     * Get a related quote item by its product id
     *
     * @param  CustomerInterface  $product
     * @return QuoteItem
     * @throws QuoteItemNotFoundException
     */
    protected function getQuoteItemByProduct(CustomerInterface $product)
    {
        $quoteItem = $this->items()->where('product_id', $product->getId())->first();

        if ($quoteItem === null) {
            throw new QuoteItemNotFoundException;
        }

         return $quoteItem;
    }
}
