import React, { useEffect, useState } from 'react';
import { Box, Button, Spinner, StackDivider, VStack } from "@chakra-ui/react"
import {
    Alert,
    AlertIcon,
    AlertDescription,
  } from "@chakra-ui/react"
  import { useToast } from "@chakra-ui/react"

import {ProductBox} from 'components/ProductBox';
import { listCart, removeFromCart, setAmount, checkoutCart } from 'rest/cart';
import {
    NumberInput,
    NumberInputField,
    NumberInputStepper,
    NumberIncrementStepper,
    NumberDecrementStepper,
  } from "@chakra-ui/react"


const Cart = () => {
    const toast = useToast()

    const [cartList, setList] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);


    const handleCheckout = () => {
        checkoutCart().then(_ => {
            toast({
              title: "Everything was delivered to your inbox ;)",
              description: '',
              status: "success",
              duration: 9000,
              isClosable: true,
            })
            setList([]);
            setIsLoading(false);
        }).catch(err => {
          setIsLoading(false);
          console.error(err);
          toast({
            title: "Something went wrong",
            description: '',
            status: "error",
            duration: 9000,
            isClosable: true,
          })
        });
    };

    const handleSetAmount = (product, x) => {
        setIsLoading(true);

        setAmount(product, x).then(_ => {
            setList(cartList.map(cartProduct => {
                if (cartProduct.data.id == product.id) {
                    cartProduct.amount = x;
                }
                return cartProduct;
            }));
            setIsLoading(false);
        }).catch(err => {
          setIsLoading(false);
          console.error(err);
          toast({
            title: "Something went wrong",
            description: '',
            status: "error",
            duration: 9000,
            isClosable: true,
          })
        })
      };

    const handleDelete = (product) => {
        if (!window.confirm('Are you sure?')) {
            return;
        }
        setIsLoading(true);

        removeFromCart(product).then(_ => {
            setList(cartList.filter(cartProduct => cartProduct.data.id != product.id));
            setIsLoading(false);
        }).catch(err => {
            setIsLoading(false);
            console.error(err);
            toast({
              title: "Something went wrong",
              description: '',
              status: "error",
              duration: 9000,
              isClosable: true,
            })
        })
      };


    useEffect(() => {
        listCart().then(res => {

            let arr = [];
            for (let id in res.data) {
                arr.push(res.data[id]);
            }
            setList(arr);

            console.log(arr);

            setIsLoading(false);
        }).catch(err => {
            setError('Something went wrong');
            console.error(err);
            setIsLoading(false);
        });
        return () => true;
    }, [])

    if (error) {
        return (
            <>
                <Alert status="error">
                    <AlertIcon />
                    <AlertDescription>{error}</AlertDescription>
                </Alert>
            </>
        )
    } else if (isLoading) {
        return (
            <>
                <div style={{'text-align': 'center', 'margin-top': '10px'}}>
                    <Spinner size="xl" />
                </div>
            </>
        )
    } else if (!cartList.length) {
        return (
            <>
                <Alert status="info">
                    <AlertIcon />
                    <AlertDescription>Nothing to show</AlertDescription>
                </Alert>
            </>
        )
    } else {
        return (
            <>

                <div style={{'text-align': 'center', 'margin-top': '10px'}}>
                    <Button
                        colorScheme="blue"
                        variant="outline"
                        onClick={handleCheckout}
                    >
                        Checkout
                    </Button>
                </div>

                <VStack
                    divider={<StackDivider borderColor="gray.200" />}
                    spacing={4}
                    >
                            {cartList.map(data =>
                                <>
                                    <ProductBox product={data.data} key={data.data.id}></ProductBox>

                                    <Box>
                                        <NumberInput maxW={32} defaultValue={data.amount} min={1} onChange={(x) => handleSetAmount(data.data, x)}>
                                        <NumberInputField />
                                        <NumberInputStepper>
                                            <NumberIncrementStepper />
                                            <NumberDecrementStepper />
                                        </NumberInputStepper>
                                        </NumberInput>
                                        <div style={{'margin-top': '10px'}}>
                                            Total: ${data.amount * data.data.price} <Button
                                                colorScheme="red"
                                                variant="outline"
                                                onClick={() => handleDelete(data.data)}
                                            >Remove</Button>
                                        </div>
                                    </Box>
                                </>
                            )}
                </VStack>
            </>
        )
    }
}

export default Cart