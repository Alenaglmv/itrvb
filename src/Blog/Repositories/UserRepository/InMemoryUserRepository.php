<?php

namespace Galim\Itrvb\Blog\Repositories\UserRepository;

use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\User;
use Galim\Itrvb\Blog\UUID;

class InMemoryUserRepository implements UserRepositoryInterface {
    private array $users = [];

    public function save(User $user): void {
        $this->users[] = $user;
    }

    public function get(UUID $uuid): User {
        foreach ($this->users as $user) {
            if ((string)$user->uuid() === (string)$uuid) {
                return $user;
            }
        }

        throw new UserNotFoundException("User not found: $uuid");
    }

    public function getByUsername(string $username): User {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }

        throw new UserNotFoundException("User not found: $username");
    }
}