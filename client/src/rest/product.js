import axios from "axios";

const instance = axios.create({
  baseURL: "https://607c843867e653001757420d.mockapi.io/api",
});

const listProducts = (page, limit) => {
  const url = `/products/products?p=${page}&l=${limit}`;

  // TODO this is for testing only (bad connection and a slow API)
  let data = sessionStorage.getItem(url);
  if (!data) {
    return instance.get(url).then((data) => {
      sessionStorage.setItem(url, JSON.stringify(data));
      return data;
    });
  } else {
    return Promise.resolve(JSON.parse(data));
  }
};

export { listProducts };
