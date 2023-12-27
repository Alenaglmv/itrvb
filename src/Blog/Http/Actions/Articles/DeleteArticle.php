<?php

namespace Galim\Itrvb\Blog\Http\Actions\Articles;

use Galim\Itrvb\Blog\Exceptions\HttpException;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Http\Actions\ActionInterface;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Http\Response;
use Galim\Itrvb\Blog\Http\ErrorResponse;
use Galim\Itrvb\Blog\Http\SuccessfulResponse;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\UUID;
use Psr\Log\LoggerInterface;

class DeleteArticle implements ActionInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository, private LoggerInterface $logger) {

    }

    public function handle(Request $request): Response
    {
        $this->logger->info("Delete article started");

        try {
            $uuid = new UUID($request->query('uuid'));
        } catch (HttpException $error) {
            return new ErrorResponse($error->getMessage());
        }

        try {
            $this->articleRepository->delete($uuid);

            $this->logger->info("Article delete: $uuid");

            return new SuccessfulResponse([
                'uuid' => (string)$uuid,
            ]);
        } catch (HttpException $error) {
            $this->logger->error($error->getMessage());
            return new ErrorResponse($error->getMessage());
        }
    }
}