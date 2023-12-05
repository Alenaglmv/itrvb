<?php

namespace Galim\Itrvb\Blog\Http\Auth;

use InvalidArgumentException;
use Galim\Itrvb\Blog\Exceptions\AuthException;
use Galim\Itrvb\Blog\Exceptions\HttpException;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\User;

class JsonBodyUuidIdentification implements IdentificationInterface
{
    public function __construct(private UserRepositoryInterface $userRepository) {

    }

    public function user(Request $request): User
    {
        try {
            $username = $request->jsonBodyField('username');
        } catch (HttpException|InvalidArgumentException $error) {
            throw new AuthException($error->getMessage());
        }

        try {
            return $this->userRepository->getByUsername($username);
        } catch (UserNotFoundException $error) {
            throw new AuthException($error->getMessage());
        }
    }
}