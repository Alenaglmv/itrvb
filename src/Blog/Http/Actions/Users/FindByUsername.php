<?php
namespace Galim\Itrvb\Blog\Http\Actions\Users;

use Galim\Itrvb\Blog\Exceptions\HttpException;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Http\Actions\ActionInterface;
use Galim\Itrvb\Blog\Http\ErrorResponse;
use Galim\Itrvb\Blog\Http\Response;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Http\SuccessfulResponse;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Psr\Log\LoggerInterface;

class FindByUsername implements ActionInterface {
    public function __construct(private UserRepositoryInterface $userRepository, private LoggerInterface $logger) {

    }
    public function handle(Request $request): Response
    {
        $this->logger->info("Find user started");

        try {
            $username = $request->query('username');
        } catch (HttpException $error) {
            return new ErrorResponse($error->getMessage());
        }

        try {
            $user = $this->userRepository->getByUsername($username);

            $this->logger->info("User find: $username");

            return new SuccessfulResponse([
                'username' => $user->getUsername(),
                'first_name' => $user->getName()->getFirstName(),
                'last_name' => $user->getName()->getLastName()
            ]);
        } catch (UserNotFoundException $error) {
            $this->logger->error($error->getMessage());
            return new ErrorResponse($error->getMessage());
        }
    }
}
