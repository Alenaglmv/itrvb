<?php

namespace Galim\Itrvb\Blog;

class User {
    public function __construct(private UUID $uuid, private string $username, private Name $name) {

    }

    public function __toString() {
        return
            "UUID : " . $this->getUuid() . "<br>" .
            "Ник пользователя: " . $this->getUsername() .
            $this->getName() . "<br>";
    }

    public function getUuid(): UUID {
        return $this->uuid;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getName(): Name {
        return $this->name;
    }

    public static function createFrom(string $username, Name $name): self
    {
        $uuid = UUID::random();
        return new self(
            $uuid,
            $username,
            $name
        );
    }
}
