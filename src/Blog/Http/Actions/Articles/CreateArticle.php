<?php

namespace Galim\Itrvb\Blog\Http\Actions\Articles;

use Galim\Itrvb\Blog\Exceptions\HttpException;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Http\Actions\ActionInterface;
use Galim\Itrvb\Blog\Http\ErrorResponse;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Http\Response;
use Galim\Itrvb\Blog\Http\SuccessfulResponse;
use Galim\Itrvb\Blog\Article;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateArticle implements ActionInterface
{
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
        private UserRepositoryInterface $userRepository,
        private LoggerInterface $logger) {

    }

    public function handle(Request $request): Response
    {
        $this->logger->info("Create article started");

        $userUuid = new UUID($request->jsonBodyField('author_uuid'));
        $user = $this->userRepository->get($userUuid);

        $newArticleUuid = UUID::random();

        try {
            $article = new Article(
                $newArticleUuid,
                $user->getUuid(),
                $request->jsonBodyField('title'),
                $request->jsonBodyField('texts')
            );
        } catch (HttpException $exception) {
            $this->logger->error($exception->getMessage());
            return new ErrorResponse($exception->getMessage());
        }

        $this->articleRepository->save($article);

        $this->logger->info("Article created: $newArticleUuid");

        return new SuccessfulResponse([
            'uuid' => (string)$newArticleUuid,
        ]);
    }
}