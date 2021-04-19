import React, { useState } from 'react';
import {
    Alert,
    AlertIcon,
    AlertDescription,
  } from "@chakra-ui/react"


const ProductList = () => {
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    if (error) {
        return (
            <>
                <Alert status="error">
                    <AlertIcon />
                    <AlertDescription>{error}</AlertDescription>
                </Alert>
            </>
        )
    } else if (!productList.length && !isLoading) {
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

export default ProductList