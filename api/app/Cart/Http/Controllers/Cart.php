<?php

namespace App\Cart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Cart\Store\Cart as CartStore;

class Cart extends BaseController
{
    public $cartStore;

    public function __construct(CartStore $cartStore)
    {
        $this->cartStore = $cartStore;
    }

    public function list(Request $request)
    {
    }

    public function add(Request $request, $id)
    {
    }

    public function setAmount(Request $request, $id)
    {
    }

    public function delete($id)
    {
    }

    public function checkout()
    {
    }
}
