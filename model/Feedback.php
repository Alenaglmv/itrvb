<?php

class Feedback {
    private $id;
    private $user;
    private $text;

    public function __construct($id, User $user, $text) {
        $this->id = $id;
        $this->user = $user;
        $this->text = $text;
    }

    public function __toString() {
        return
            "ID : " . $this->getId() . "<br>" .
            "Пользователь : " . $this->getUser() . "<br>" .
            "Текст : " . $this->getText() . "<br>";
    }

    private function getId() {
        return $this->id;
    }

    private function getUser() {
        return $this->user->getFirstName();
    }

    private function getText() {
        return $this->text;
    }
}