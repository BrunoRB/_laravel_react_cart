
<?php

/**
 * @OA\Info(
 *      version="0.0.1",
 *      title="Cart app",
 *      description="Simple laravel & Rect cart system",
 * )
 */

/**
 * @OA\Get(
 *      path="/cart",
 *      tags={"cart"},
 *      summary="Return list of items in cart session",
 *      description="",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *           @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                property="333",
 *                type="object",
 *                example={
 *                  "id":"333",
 *                  "productName":"Handmade Plastic Cheese",
 *                  "price":"828.00",
 *                  "imageUrl":"http://lorempixel.com/640/480/business",
 *                  "url":"https://otho.org",
 *                  "product":"Shirt"
 *                 },
 *             ),
 *             @OA\Property(
 *                property="55",
 *                type="object",
 *                example={
 *                  "id":"55",
 *                  "productName":"Handmade Plastic Cheese",
 *                  "price":"828.00",
 *                  "imageUrl":"http://lorempixel.com/640/480/business",
 *                  "url":"https://otho.org",
 *                  "product":"Shirt"
 *                 },
 *             ),
 *        ),

 *       ),
 *       @OA\Response(response=400, description="Bad request")
 *       @OA\Response(response=422, description="Invalid parameters")
 *     )
 */

/**
 * @OA\Put(
 *      path="/cart/product/{id}",
 *      tags={"cart"},
 *      summary="Place a new item inside the cart",
 *      description="",
 *     @OA\Parameter(
 *         name="data",
 *         in="query",
 *         description="Product data",
 *         required=true,
 *         @OA\Schema(
 *                type="object",
 *                example={
 *                  "id":"55",
 *                  "productName":"Handmade Plastic Cheese",
 *                  "price":"828.00",
 *                  "imageUrl":"http://lorempixel.com/640/480/business",
 *                  "url":"https://otho.org",
 *                  "product":"Shirt"
 *                 },
 *         ),
 *         style="form"
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request")
 *       @OA\Response(response=422, description="Invalid parameters")
 *     )
 */

/**
 * @OA\Patch(
 *      path="/cart/product/{id}",
 *      tags={"cart"},
 *      summary="Change the amount of data for a product inside the cart",
 *      description="",
 *
 *     @OA\Parameter(
 *         name="amount",
 *         in="query",
 *         description="How many products",
 *         required=true,
 *         @OA\Schema(
 *           type="int"
 *         ),
 *         style="form"
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request")
 *       @OA\Response(response=422, description="Invalid parameters")
 *     )
 */

/**
 * @OA\Delete(
 *      path="/cart/product/{id}",
 *      tags={"cart"},
 *      summary="Remove item from cart",
 *      description="",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request")
 *     )
 */

/**
 * @OA\Post(
 *      path="/cart/checkout",
 *      tags={"cart"},
 *      summary="Checkout cart.",
 *      description="",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       @OA\Response(response=404, description="Nothing to checkout")
 *     )
 *
 */