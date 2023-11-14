<?php

namespace Galim\Itrvb\Blog\Commands;

use Galim\Itrvb\Blog\Exceptions\CommandException;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Name;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\User;
use Galim\Itrvb\Blog\UUID;

class CreateUserCommand {
    public function __construct(private UserRepositoryInterface $userRepository) {

    }

    public function handle(Arguments $arguments): void {
        $username = $arguments->get('username');

        if($this->userExist($username)) {
            throw new CommandException("User already exists: $username");
        }

        $this->userRepository->save(new User(
            UUID::random(),
            $username,
            new Name($arguments->get('first_name'), $arguments->get('last_name'))
        ));
    }

     public function userExist(string $username): bool {
            try {
            $this->userRepository->getByUsername($username);
        }
        catch (UserNotFoundException) {
            return false;
        }

        return true;
    }
}