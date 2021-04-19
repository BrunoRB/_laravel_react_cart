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
        $key = self::getKey($productId);

        $data = request()->session()->get($key);
        if ($data) {
            $data['amount'] = $amount;
            request()->session()->put($key, $data);
        }
    }

    public function delete($productId)
    {
        request()->session()->forget(self::getKey($productId));
    }

    public function list(): array
    {
        return request()->session()->get('cart.products') ?? [];
    }

    public function clear()
    {
        return request()->session()->forget('cart.products');
    }

}