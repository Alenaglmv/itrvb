<?php

class Review {
    private $id;
    private $product;
    private $user;
    private $grade;
    private $text;

    public function __construct($id, Product $product, User $user, $grade, $text) {
        $this->id = $id;
        $this->product = $product;
        $this->user = $user;
        $this->grade = $grade;
        $this->text = $text;
    }

    public function __toString() {
        return
            "ID : " . $this->getId() . "<br>" .
            "Продукт : " . $this->getProduct() . "<br>" .
            "Пользователь : " . $this->getUser() . "<br>" .
            "Оценка : " . $this->getGrade() . "<br>" .
            "Текст : " . $this->getText() . "<br>";
    }

    private function getId() {
        return $this->id;
    }

    private function getProduct() {
        return $this->product->getName();
    }

    private function getUser() {
        return $this->user->getFirstName();
    }

    private function getGrade() {
        return $this->grade;
    }

    private function getText() {
        return $this->text;
    }
}