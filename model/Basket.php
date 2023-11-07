<?php

class Basket {
    private $products = [];

    public function getProducts() {
        return $this->products;
    }

    public function addProduct(Product $product, $count) {
        $this->products[] = ['product' => $product, 'count' => $count];
    }

    public function removeProduct(Product $product) {
        foreach ($this->products as $key => $value) {
            if ($value['product'] === $product) {
                unset($this->products[$key]);
                break;
            }
        }
    }
}