<?php

class User {
    private $id;
    private $firstName;
    private $surName;
    private $mail;

    public function __construct($id, $firstName, $surName, $mail) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->surName = $surName;
        $this->mail = $mail;
    }

    public function __toString() {
        return
            "ID: " . $this->getId() . "<br>" .
            "Имя : " . $this->getFirstName() . "<br>" .
            "Фамилия : " . $this->getSurName() . "<br>" .
            "Почта : " . $this->getMail() . "<br>";
    }

    private function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    private function getSurName() {
        return $this->surName;
    }

    private function getMail() {
        return $this->mail;
    }
}