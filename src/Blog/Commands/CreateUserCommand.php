<?php

namespace Galim\Itrvb\Blog\Commands;

use Galim\Itrvb\Blog\Exceptions\CommandException;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Name;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\User;
use Galim\Itrvb\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateUserCommand {
    public function __construct(private UserRepositoryInterface $userRepository, private LoggerInterface $logger) {

    }

    public function handle(Arguments $arguments): void {
        $this->logger->info("Create user command started");


        $username = $arguments->get('username');

        if($this->userExist($username)) {
            $this->logger->warning("User already exists: $username");
            throw new CommandException("User already exists: $username");
        }
        $uuid = UUID::random();
        $this->userRepository->save(new User(
            $uuid,
            $username,
            new Name($arguments->get('first_name'), $arguments->get('last_name'))
        ));

        $this->logger->info("User created: $uuid");
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