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
        // we use the data "as is", so no need for a Resource.
        return $this->cartStore->list();
    }

    public function add(Request $request, $id)
    {
        $validated = $request->validate([
            'data' => 'required|array',
            'data.productName' => 'required',
            'data.price' => 'required',
            'data.product' => 'required',
            'data.url' => 'required|url',
            'data.imageUrl' => 'required|url',
        ]);

         $this->cartStore->add($id, $validated['data']);
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
