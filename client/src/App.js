import React from "react";
import { Switch, Route, BrowserRouter, Link } from "react-router-dom";
import { ChakraProvider } from "@chakra-ui/react";

import ProductList from "./pages/ProductList";
import Cart from "pages/Cart";

import { Divider } from "@chakra-ui/react";
import { Button } from "@chakra-ui/react";
import { Flex, Spacer, Box } from "@chakra-ui/react";

const AppRoutes = () => (
  <BrowserRouter>
    <Flex>
      <Box p="4">
        <Button colorScheme="green" size="lg">
          <Link to="/">Home</Link>
        </Button>
      </Box>
      <Spacer />
      <Box p="4">
        <Button colorScheme="blue" size="lg">
          <Link to="/cart">Cart</Link>
        </Button>
      </Box>
    </Flex>

    <Divider orientation="horizontal" />

    <Switch>
      <Route exact path="/">
        <ProductList />
      </Route>
      <Route exact path="/cart">
        <Cart />
      </Route>
    </Switch>
  </BrowserRouter>
);

const App = () => {
  return (
    <ChakraProvider>
      <AppRoutes />
    </ChakraProvider>
  );
};

export default App;
