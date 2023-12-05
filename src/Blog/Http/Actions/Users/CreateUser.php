<?php

namespace Galim\Itrvb\Blog\Http\Actions\Users;

use Psr\Log\LoggerInterface;
use Galim\Itrvb\Blog\Exceptions\HttpException;
use Galim\Itrvb\Blog\Http\Actions\ActionInterface;
use Galim\Itrvb\Blog\Http\ErrorResponse;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Http\Response;
use Galim\Itrvb\Blog\Http\SuccessfulResponse;
use Galim\Itrvb\Blog\Name;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\User;
use Galim\Itrvb\Blog\UUID;

class CreateUser implements ActionInterface
{
    public function __construct(private UserRepositoryInterface $usersRepository) {

    }

    public function handle(Request $request): Response
    {
        try {
            $uuid = UUID::random();

            $user = new User(
                $uuid,
                $request->jsonBodyField('username'),
                new Name(
                    $request->jsonBodyField('first_name'),
                    $request->jsonBodyField('last_name')
                )
            );
        } catch (HttpException $exception)
        {
            return new ErrorResponse($exception->getMessage());
        }
        $this->usersRepository->save($user);
        return new SuccessfulResponse([
            'uuid'=> (string)$uuid
        ]);
    }
}