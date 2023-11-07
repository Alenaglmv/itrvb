<?php

class PieceProduct extends Product {
    private $count;

    public function __construct($id, $name, $price, $count) {
        parent::__construct($id, $name, $price);
        $this->count = $count;
    }

    public function __toString() {
        return
            parent::__toString() .
            "Количество : " . $this->getCount() . "<br>" .
            "Итоговая стоимость : " . $this->calculationFinalPrice() . "<br>";
    }

    private function getCount() {
        return $this->count;
    }

    protected function calculationFinalPrice() {
        return $this->price * $this->count * 2;
    }
}