<?php

namespace App\Cart\Store;

interface Cart
{
    public function add($productId, array $data);

    public function delete($productId);

    public function list(): array;

    public function setAmount($productId, int $amount);

    public function clear();

}