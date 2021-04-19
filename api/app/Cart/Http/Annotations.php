
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
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request")
 *     )
 */

/**
 * @OA\Put(
 *      path="/cart/product/{id}",
 *      tags={"cart"},
 *      summary="Place a new item inside the cart",
 *      description="",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request")
 *     )
 */

/**
 * @OA\Patch(
 *      path="/cart/product/{id}",
 *      tags={"cart"},
 *      summary="Change the amount of data for a product inside the cart",
 *      description="",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
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
 *       @OA\Response(response=400, description="Bad request")
 *     )
 *
 */