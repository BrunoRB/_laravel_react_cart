import axios from "axios";

const instance = axios.create({
  baseURL: "/api/cart",
});

const addToCart = (product) => {
  return instance.put(`/product/${product.id}`, {
    data: product,
  });
};

const setAmount = (product, amount) => {
  return instance.patch(`/product/${product.id}`, {
    amount: amount,
  });
};

const removeFromCart = (product) => {
  return instance.delete(`/product/${product.id}`);
};

const checkoutCart = () => {
  return instance.post(`/checkout`);
};

const listCart = () => {
  return instance.get();
};

export { addToCart, setAmount, removeFromCart, checkoutCart, listCart };
