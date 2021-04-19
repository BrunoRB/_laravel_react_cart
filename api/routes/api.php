<?php

use App\Cart\Http\Controllers\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['session'])->group(function () {
    Route::get('/cart', [Cart::class, 'list']);

    Route::put('/cart/product/{id}', [Cart::class, 'add']);

    Route::patch('/cart/product/{id}', [Cart::class, 'setAmount']);

    Route::delete('/cart/product/{id}', [Cart::class, 'delete']);


    Route::post('/cart/checkout', [Cart::class, 'checkout']);
});