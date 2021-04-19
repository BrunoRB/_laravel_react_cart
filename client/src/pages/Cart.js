import React, { useEffect, useState } from 'react';
import {
    Alert,
    AlertIcon,
    AlertDescription,
    Spinner
  } from "@chakra-ui/react"


const Cart = () => {
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);
    const [cartList, setList] = useState([]);

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
                <Spinner />
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
            </>
        )
    }
}

export default Cart