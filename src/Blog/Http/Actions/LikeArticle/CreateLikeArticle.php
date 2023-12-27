<?php

namespace Galim\Itrvb\Blog\Http\Actions\LikeArticle;

use Galim\Itrvb\Blog\Exceptions\CommandException;
use Galim\Itrvb\Blog\Exceptions\HttpException;
use Galim\Itrvb\Blog\Http\Actions\ActionInterface;
use Galim\Itrvb\Blog\LikeArticle;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\LikeArticleRepository\LikeArticleRepositoryInterface;
use Galim\Itrvb\Blog\Http\ErrorResponse;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Http\Response;
use Galim\Itrvb\Blog\Http\SuccessfulResponse;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateLikeArticle implements ActionInterface {
    public function __construct(
        private LikeArticleRepositoryInterface $likeArticleRepository,
        private UserRepositoryInterface $userRepository,
        private ArticleRepositoryInterface $articleRepository,
        private LoggerInterface $logger) {

    }

    public function handle(Request $request): Response
    {
        $this->logger->info("Create like article started");

        $articleUuid = new UUID($request->jsonBodyField('article_uuid'));
        $article = $this->articleRepository->get($articleUuid);

        $userUuid = new UUID($request->jsonBodyField('user_uuid'));
        $user = $this->userRepository->get($userUuid);

        $uuid = UUID::random();

        try {
            $likeArticle = new LikeArticle(
                $uuid,
                $article->getUuid(),
                $user->getUuid(),
            );
        } catch (HttpException $exception) {
            $this->logger->error($exception->getMessage());
            return new ErrorResponse($exception->getMessage());
        }
        $this->likeArticleRepository->save($likeArticle);

        $this->logger->info("Like article created: $uuid");

        return new SuccessfulResponse([
            'uuid'=> (string)$uuid
        ]);
    }
}