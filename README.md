
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

- all relevant code will be in a separate "module" `app/Cart` (controllers, mailables, etc)

- The core abstraction of the system "Cart", in which we hold products selected by the user. We'll define a `Cart` contract that
specifies the operations demanded by the our API. This contract guarantees that we can implement our cart using whatever
storage system we want (session, database, etc). For simplicity (and time...) reasons I'll probably only implement a session-based storage here, and then add notes about a more robust one.

- The "Cart" service will be handled by a Service Provider.

- Checkout will trigger a mailable

- We'll consider products a separate system. As suggested in the pdf the list will be fetched from some API. An implication of this detachment is that we'll likely have to replicate some product data in the Cart storage so we can display it in the cart details page.

- A note about the checkout process: I'm going with a session-only cart system, but in a real app that would not be enogh. We would need a proper database storage, and would have something similar to this:
  - anonymous users remain in with the session storage. logged users always have the database one.
  - when an anonymous users logs in for the checkout process, we would move the whole cartsession to the databasession.
  - instead of clearing the whole cart, the checkout process would set a "checked_out_at" flag so that we don't lose information.

- I won't place a lot of focus on the layout

## Running

...