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

    public function testInvalidAdd()
    {
        $productId = $this->faker->uuid;

        $data = $this->getFakeProductData();
        unset($data['id']);

        $arr = [
            [],
            $data
        ];
        foreach($arr as $payload) {
            $response = $this->json('put', '/api/cart/product/' . $productId, [
                'data' => $payload
            ]);
            $response->assertStatus(422);
        }
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
            ->json('patch', '/api/cart/product' . rand(1, 99), [
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
            ->json('patch', '/api/cart/product/' . $data['id'], [
                'amount' => 5
            ]);
        $response->assertStatus(200);

        $sessionData = request()->session()->get(SessionCart::getKey($data['id']));

        $this->assertEquals(5, $sessionData['amount']);
    }

    public function testChangeToInvalidAmount()
    {
        $data = $this->getFakeProductData();
        $cartSessionData[SessionCart::getKey($data['id'])] = [
            'amount' => 1,
            'data' => $data
        ];

        foreach([-10, -1, 0] as $i) {
            $response = $this
                ->withSession($cartSessionData)
                ->json('patch', '/api/cart/product/' . $data['id'], [
                    'amount' => -1
                ]);
            $response->assertStatus(422);
        }
    }

    public function testDelete()
    {
        $data = $this->getFakeProductData();
        $cartSessionData[SessionCart::getKey($data['id'])] = [
            'amount' => 1,
            'data' => $data
        ];

        $response = $this
            ->withSession($cartSessionData)
            ->json('delete', '/api/cart/product/' . $data['id']);
        $response->assertStatus(200);
        $this->assertFalse(
            request()->session()->has(SessionCart::getKey($data['id']))
        );
    }

    public function testDeleteInexistent()
    {
        $response = $this
            ->json('delete', '/api/cart/product/' . rand(1, 1111111));
        /**
         * 200, we don't care if existed or not before, the end result is the same.
         */
        $response->assertStatus(200);
    }

    public function testCheckoutEmptyCart()
    {
        $response = $this
            ->json('post', '/api/cart/checkout');
        $response->assertStatus(404);
    }

    public function testCheckout()
    {
        // $this->markTestIncomplete('TODO');

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
            ->json('post', '/api/cart/checkout');
        $response->assertStatus(200);

        foreach($cartSessionData as $id => $_) {
            $this->assertFalse(
                request()->session()->has(SessionCart::getKey($id))
            );
        }

        // TODO assert emails was sent

    }

}
