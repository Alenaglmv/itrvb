<?php

class WeightProduct extends Product {
    private $weight;

    public function __construct($id, $name, $price, $weight) {
        parent::__construct($id, $name, $price);
        $this->weight = $weight;
    }

    public function __toString() {
        return
            parent::__toString() .
            "Вес : " . $this->getWeight() . "кг<br>" .
            "Итоговая стоимость : " . $this->calculationFinalPrice() . "<br>";
    }

    private function getWeight() {
        return $this->weight;
    }

    protected function calculationFinalPrice() {
        return $this->price * $this->weight * 2;
    }
}