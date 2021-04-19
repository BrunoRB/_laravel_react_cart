import React, { useEffect, useState } from 'react';
import { Button, Spinner } from "@chakra-ui/react"
import {
    Alert,
    AlertIcon,
    AlertDescription,
  } from "@chakra-ui/react"
import { SimpleGrid } from "@chakra-ui/react"

import {ProductBox} from 'components/ProductBox';
import { listProducts } from 'rest/product';


const ProductList = () => {
    const [productList, setList] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    // pretend this is coming together with the "loadNext" data
    const [total, setTotal] = useState(100);
    const [page, setPage] = useState(1);

    const loadNext = () => {
        const limit = 5;
        setIsLoading(true);
        listProducts(page, limit).then(res => {
            setList(productList.concat(res.data));

            setIsLoading(false);
        }).catch(err => {
            setError('Something went wrong');
            console.error(err);
            setIsLoading(false);
        });

        setPage(page + 1);
    };


    useEffect(() => {
        loadNext();
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
                <SimpleGrid columns={5} spacing={10}>
                    {productList.map(product => {
                        return <ProductBox displayAddToCart={true} product={product} key={product.id}></ProductBox>;
                    })}

                </SimpleGrid>
                <center></center>
                <div style={{'text-align': 'center', 'margin-top': '50px'}}>
                        {productList.length < total ? (
                            isLoading ?
                            <Spinner></Spinner> :
                            <Button colorScheme="blue" onClick={loadNext}>Display more</Button>
                        ) : ''
                    }
                </div>
            </>
        )
    }
}

export default ProductList