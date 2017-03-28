<?php

namespace WTG\Checkout\Providers;

use Illuminate\Support\ServiceProvider;

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
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');

        $this->loadMigrationsFrom(__DIR__.'/../Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'checkout');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
