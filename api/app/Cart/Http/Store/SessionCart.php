<?php

namespace App\Cart\Store;

class SessionCart implements Cart
{
    public static function getKey($productId)
    {
    }

    public function add($productId, array $data)
    {
    }


    public function setAmount($productId, int $amount)
    {

    }

    public function delete($productId)
    {
    }

    public function list(): array
    {
        return [];
    }

    public function clear()
    {
    }

}