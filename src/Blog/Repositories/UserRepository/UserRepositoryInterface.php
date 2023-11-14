<?php

namespace Galim\Itrvb\Blog\Repositories\UserRepository;

use Galim\Itrvb\Blog\User;
use Galim\Itrvb\Blog\UUID;

interface UserRepositoryInterface {
    public function save(User $user): void;
    public function get(UUID $uuid): User;
    public function getByUsername(string $username): User;
}