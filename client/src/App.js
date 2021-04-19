import React from 'react'
import { Switch, Route, BrowserRouter, Link } from 'react-router-dom'
import { ChakraProvider } from "@chakra-ui/react"

import ProductList from './pages/ProductList'
import Cart from 'pages/Cart'

import { Divider } from "@chakra-ui/react"
import { Button } from "@chakra-ui/react"
import { IconButton } from "@chakra-ui/react"


const AppRoutes = () => (
    <BrowserRouter>

        <Button colorScheme="green"><Link to="/">Home</Link></Button>
        <Button colorScheme="blue"><Link to="/cart">Cart</Link></Button>

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
)

const App = () => {
    return (
      <ChakraProvider>
        <AppRoutes />
      </ChakraProvider>
    )
}

export default App;
