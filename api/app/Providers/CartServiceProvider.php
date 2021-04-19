<?php

namespace App\Providers;

use App\Cart\Store\Cart;
use App\Cart\Store\SessionCart;
use Exception;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Cart::class, function ($app) {
            if (strtolower(config('cart.storage')) === 'session') {
                return new SessionCart();

            } else {
                throw new Exception('Not implemented');
            }
        });
    }

    public function boot()
    {
        //
    }
}
