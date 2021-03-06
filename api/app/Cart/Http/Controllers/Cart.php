<?php

namespace App\Cart\Http\Controllers;

use App\Cart\Mail\CheckoutMail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Cart\Store\Cart as CartStore;
use Illuminate\Support\Facades\Mail;

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
            'data.id' => 'required',
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
        $validated = $request->validate([
            'amount' => 'required|int|min:1'
        ]);

        $this->cartStore->setAmount($id, $validated['amount']);
    }

    public function delete($id)
    {
        $this->cartStore->delete($id);
    }

    public function checkout()
    {
        $data = $this->cartStore->list();
        if (!$data) {
            abort(404, 'Nothing to checkout');
        }

        Mail::send(new CheckoutMail($data));

        $this->cartStore->clear();
    }
}
