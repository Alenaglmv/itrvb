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
    public function __construct(private UserRepositoryInterface $usersRepository, private LoggerInterface $logger) {

    }

    public function handle(Request $request): Response
    {
        $this->logger->info("Create user started");

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
        } catch (HttpException $exception) {
            $this->logger->error($exception->getMessage());
            return new ErrorResponse($exception->getMessage());
        }
        $this->usersRepository->save($user);

        $this->logger->info("User created: $uuid");

        return new SuccessfulResponse([
            'uuid'=> (string)$uuid
        ]);
    }
}