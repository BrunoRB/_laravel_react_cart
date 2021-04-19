import React, { useEffect, useState } from "react";
import { Box } from "@chakra-ui/react";
import { Image } from "@chakra-ui/react";
import { Button } from "@chakra-ui/react";
import { addToCart } from "rest/cart";
import { useToast } from "@chakra-ui/react";

const ProductBox = (props) => {
  const toast = useToast();

  const [isLoading, setIsLoading] = useState(false);
  const handleAddToCart = () => {
    setIsLoading(true);

    addToCart(props.product)
      .then((xs) => {
        setIsLoading(false);
        toast({
          title: "Product added to cart",
          description: "",
          status: "success",
          duration: 9000,
          isClosable: true,
        });

        return xs;
      })
      .catch((err) => {
        setIsLoading(false);
        toast({
          title: "Something went wrong",
          description: "",
          status: "error",
          duration: 9000,
          isClosable: true,
        });
      });
  };

  return (
    <>
      <Box maxW="sm" overflow="hidden">
        {/* <Image src={props.product.imageUrl} alt={props.product.product} /> */}

        <Box p="6">
          <Box mt="1" fontWeight="semibold" as="h4" lineHeight="tight">
            {props.product.productName}
          </Box>

          {props.displayAddToCart ? (
            <Box>
              {props.product.product}
              <br />${props.product.price}
              <div>
                <Button
                  isLoading={isLoading}
                  loadingText="Adding"
                  colorScheme="teal"
                  variant="outline"
                  onClick={handleAddToCart}
                >
                  Add to cart
                </Button>
              </div>
            </Box>
          ) : (
            ""
          )}
        </Box>
      </Box>
    </>
  );
};

export { ProductBox };
