<?php

class ProductCard extends Product {
    private $image;
    private $brand;

    public function __construct(Product $product, $image, $brand) {
        parent::__construct($product->getId(), $product->getName(), $product->getContent(), $product->getPrice());
        $this->image = $image;
        $this->brand = $brand;
    }

    public function __toString() {
        return
            parent::__toString() .
            "Картинка : <img src='" . $this->getImage() . "' alt='img' width='100' height='100'>" . "<br>" .
            "Производитель : " . $this->getBrand() . "<br>";
    }

    private function getImage() {
        return $this->image;
    }

    private function getBrand() {
        return $this->brand;
    }
}