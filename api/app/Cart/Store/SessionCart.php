<?php

namespace App\Cart\Store;

class SessionCart implements Cart
{
    public static function getKey($productId)
    {
        return 'cart.products.' . $productId;
    }

    public function add($productId, array $data)
    {
        $key = self::getKey($productId);

        $count = request()->session()->get($key, [
            'amount' => 0
        ])['amount'];

        request()->session()->put($key, [
            'amount' => $count + 1,
            'data' => $data
        ]);
    }


    public function setAmount($productId, int $amount)
    {

    }

    public function delete($productId)
    {
    }

    public function list(): array
    {
    }

    public function clear()
    {
    }

}