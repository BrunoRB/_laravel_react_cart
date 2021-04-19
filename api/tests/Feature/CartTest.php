<?php

namespace Tests\Feature;

use App\Cart\Store\SessionCart;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CartTest extends TestCase
{
    use WithFaker;

    public function tearDown(): void
    {
        if (request()->hasSession()) {
            request()->session()->flush();
        }
        parent::tearDown();
    }

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

    public function testListEmpty()
    {
        $response = $this->get('/api/cart');

        $response->assertStatus(200);

        $list = $response->decodeResponseJson();
        $this->assertEmpty($list);
    }

    public function testList()
    {
        $cartSessionData = [];
        foreach(range(1, 5) as $_) {
            $data = $this->getFakeProductData();
            $cartSessionData[SessionCart::getKey($data['id'])] = [
                'amount' => rand(1, 5),
                'data' => $data
            ];
        }

        $response = $this
            ->withSession($cartSessionData)
            ->get('/api/cart');

        $response->assertStatus(200);

        $list = $response->decodeResponseJson();
        $this->assertEquals(5, count($list));
    }

    public function testChangeAmountInexistent()
    {
        $response = $this
            ->patch('/api/cart/product' . rand(1, 99), [
                'amount' => 5
            ]);
        $response->assertStatus(404);
    }

    public function testSetChangeAmount()
    {
        $data = $this->getFakeProductData();
        $cartSessionData[SessionCart::getKey($data['id'])] = [
            'amount' => 1,
            'data' => $data
        ];

        $response = $this
            ->withSession($cartSessionData)
            ->patch('/api/cart/product/' . $data['id'], [
                'amount' => 5
            ]);
        $response->assertStatus(200);

        $sessionData = request()->session()->get(SessionCart::getKey($data['id']));

        $this->assertEquals(5, $sessionData['amount']);
    }

    // public function testChangeToInvalidAmount()
    // {
    //     $response = $this
    //         ->patch('/api/cart/' . rand(1, 99));
    //     $response->assertStatus(400);
    // }

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
