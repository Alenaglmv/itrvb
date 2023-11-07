<?php

class Product {
    private $id;
    private $name;
    private $content;
    private $price;

    public function __construct($id, $name, $content, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->content = $content;
        $this->price = $price;
    }

    public function __toString() {
        return
            "ID: " . $this->getId() . "<br>" .
            "Наименование : " . $this->getName() . "<br>" .
            "Описание : " . $this->getContent() . "<br>" .
            "Цена : " . $this->getPrice() . " рублей<br>";
    }

    protected function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    protected function getPrice() {
        return $this->price;
    }

    protected function getContent() {
        return $this->content;
    }
}