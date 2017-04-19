<?php

namespace WTG\Checkout\Providers;

use WTG\Checkout\Models\Order;
use WTG\Checkout\Models\Quote;
use WTG\Checkout\Models\OrderItem;
use WTG\Checkout\Models\QuoteItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use WTG\Checkout\Interfaces\OrderInterface;
use WTG\Checkout\Interfaces\QuoteInterface;
use WTG\Checkout\Interfaces\OrderItemInterface;
use WTG\Checkout\Interfaces\QuoteItemInterface;

/**
 * Checkout service provider
 *
 * @package     WTG\Checkout
 * @subpackage  Providers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class CheckoutServiceProvider extends ServiceProvider
{
    /**
     * @var Quote
     */
    protected $quote;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');

        $this->loadMigrationsFrom(__DIR__.'/../Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'checkout');

        View::composer('*', function ($view) {
            if (\Auth::check()) {
                if ($this->quote === null) {
                    $this->quote = Quote::findQuoteByCustomerId(\Auth::id(), \Auth::user()->getCompanyId());
                }

                $view->with('quote', $this->quote);
            }
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QuoteInterface::class, Quote::class);
        $this->app->bind(QuoteItemInterface::class, QuoteItem::class);
        $this->app->bind(OrderInterface::class, Order::class);
        $this->app->bind(OrderItemInterface::class, OrderItem::class);
    }
}
