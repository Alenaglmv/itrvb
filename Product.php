<?php

abstract class Product {
    protected $id;
    protected $name;
    protected $price;

    public function __construct($id, $name, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function __toString() {
        return
            "ID : " . $this->getID() . "<br>" .
            "Название : " . $this->getName() . "<br>" .
            "Цена : " . $this->getPrice() . "<br>";
    }

    protected function getID() {
        return $this->id;
    }

    protected function getName() {
        return $this->name;
    }

    protected function getPrice() {
        return $this->price;
    }

    abstract protected function calculationFinalPrice();
}