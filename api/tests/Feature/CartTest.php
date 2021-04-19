<?php

namespace Tests\Feature;

use App\Cart\Store\SessionCart;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CartTest extends TestCase
{
    use WithFaker;

    private function getFakeProductData()
    {
        return [
            'id' => $this->faker->uuid,
            'productName' => $this->faker->name,
            'price' => $this->faker->randomFloat,
            'imageUrl' => $this->faker->url,
            'url' => $this->faker->url,
            'product' => $this->faker->name,
        ];
    }

    public function testBasicAdd()
    {
        $productId = $this->faker->uuid;

        $data = $this->getFakeProductData();

        $response = $this->put('/api/cart/product/' . $productId, [
            'data' => $data
        ]);
        $response->assertStatus(200);

        $sessionData = request()->session()->get(SessionCart::getKey($productId));

        $this->assertArrayHasKey('amount', $sessionData);
        $this->assertArrayHasKey('data', $sessionData);
        $this->assertArrayHasKey('id', $sessionData['data']);

        $this->assertEquals(1, $sessionData['amount']);
        $this->assertEquals($data['id'], $sessionData['data']['id']);
        $this->assertEquals($data['productName'], $sessionData['data']['productName']);
    }

    public function testAddMultipleTimes()
    {
        $this->markTestIncomplete('TODO');
    }

    public function testListEmpty()
    {
        $productId = $this->faker->uuid;

        $data = $this->getFakeProductData();

        foreach(range(1, 10) as $i) {
            $data['productName'] = $this->faker->name;

            $response = $this->put('/api/cart/product/' . $productId, [
                'data' => $data
            ]);
            $response->assertStatus(200);

            $sessionData = request()->session()->get(SessionCart::getKey($productId));

            $this->assertArrayHasKey('amount', $sessionData);
            $this->assertArrayHasKey('data', $sessionData);
            $this->assertArrayHasKey('id', $sessionData['data']);

            $this->assertEquals($i, $sessionData['amount']);
            $this->assertEquals($data['id'], $sessionData['data']['id']);
            $this->assertEquals($data['productName'], $sessionData['data']['productName']);
        }
    }

    public function testList()
    {
        $this->markTestIncomplete('TODO');
    }

    public function setChangeAmount()
    {
        $this->markTestIncomplete('TODO');
    }

    public function testChangeAmountInexistent()
    {
        $this->markTestIncomplete('TODO');
    }

    public function testChangeToInvalidAmount()
    {
        $this->markTestIncomplete('TODO');
    }

    public function testCheckoutEmptyCart()
    {
        $this->markTestIncomplete('TODO');
    }

    public function testCheckout()
    {
        $this->markTestIncomplete('TODO');
    }

    public function testDelete()
    {
        $this->markTestIncomplete('TODO');
    }

    public function testInexistent()
    {
        $this->markTestIncomplete('TODO');
    }

}
