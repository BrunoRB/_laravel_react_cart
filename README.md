
# Cart checkout system

- add items
- list all items belonging to a cart
- get a resume of the cart (with totals)
- delete items
- change totals of items in cart
- checkout cart

## General idea (the plan):

- will not deal with authentication nor authorization

- will not deal with product stock avaiability

- The core abstraction of the system "Cart", in which we hold products selected by the user. We'll define a `Cart` contract that
specifies the operations demanded by the our API. This contract guarantees that we can implement our cart using whatever
storage system we want (session, database, etc). For simplicity (and time...) reasons I'll probably only implement a session-based storage here, and then add notes about a more robust one.

- The "Cart" service will be handled by a Service Provider.

- Checkout will trigger a mailable

- We'll consider products a separate system. As suggested in the pdf the list will be fetched from some API. An implication of this detachment is that we'll likely have to replicate some product data in the Cart storage so we can display it in the cart details page.

## Api

- `/api/documentation` (once you have the server running)

- `api/app/Cart/Http/Annotations.php`. It's probably wrong in some points, as I'm not super familiar with Swagger notation. FYI I started using it some years ago, but ended up going the GraphQL route (which gives you endpoint documentation "for free").


## Running

Back

- `cd api/`
- `composer install`
- `php artisan serve` (the client proxy assume you're running the app at `http://localhost:8000`)
- .env vars
    - `CART_STORAGE`, default to `session`, the only implemented value
    - `CHECKOUT_EMAIL_ADDRESS`, where to send the parsed checkout email.
        Defaults to null, and the app won't work properly without this value
- You also have to set up your mail crendentials. Standard laravel mail vars. I recommend mailtrap.io for testing.

Front
- `cd client/`
- `yarn install`
- `yarn start`
- again, note that we expect the app in locahost port 8000 (package.json.proxy)
 - Product API https://607c843867e653001757420d.mockapi.io/api/products/products?p=1&l=10 (it's missing a "total" value, but we'll hardcoded that as 100 in the code)


## Final notes

 - backend code in `app\Cart`

 - fronted broked down into `src/Pages` (route components), `src/Components` (fragment components) and `src/rest` (api calling services)
 
 - tests in `api/tests/Feature/CartTest.php`. It's quite complete in terms of covering the whole API and functionality, but in a real app I would definitly have the more granular actual unit tests.

 - the backend session-only storage system is obvioulsy just a toy. A "real" app would have a database cart for logged users (transfering from the session to the db once you log in), and also we could have the session cart fully inside the client side (session or local browser storages). There's also https://github.com/darryldecode/laravelshoppingcart, which gives essentially the same `Cart` abstraction I implemented.


  - I dind't deal with product stock avaiability in the code, but here's a pseudo of how it would look like:

```
// app/Cart/Http/Controllers/Cart.php->checkout
fucntion checkout()

  cartData = cart.getList()

  checkoutEntity = CheckoutModel::create(cartData)

  DoCheckoutJob::dispatch(checkoutEntity)

  cart.clear()

...

class DoCheckoutJob imlements ShouldQueue

  handle()
      openTransaction()

      try
        checkoutEntity.finsihed_at = now()
        checkoutEntity.save()

        // talk to the external system to make sure we are not selling something out of stock
        // the system likely needs to generate some mutex Lock in order to prevent race conditions
        available = ExternalProductSystem.getStockAvaiability(checkoutEntity.items())

        checkInDatabaseWichItemsGotAcutallySold(available) 

        sendParsedMail()

        commit()
      catch
        rollback()

```

Finally, the app is super rought around the edges, as I went for something simple and quick to implement , but that is "feature complete" and displays my general understanding of the specs, stack and that I'm aware of what's missing if were to build it "for real". 