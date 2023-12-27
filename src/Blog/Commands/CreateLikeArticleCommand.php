<?php

namespace Galim\Itrvb\Blog\Commands;

use Galim\Itrvb\Blog\Exceptions\ArticleNotFoundException;
use Galim\Itrvb\Blog\Exceptions\CommandException;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\LikeArticle;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\LikeArticleRepository\LikeArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateLikeArticleCommand {
    public function __construct(
        private LikeArticleRepositoryInterface $likeArticleRepository,
        private ArticleRepositoryInterface $articleRepository,
        private UserRepositoryInterface $userRepository,
        private LoggerInterface $logger) {

    }

    public function handle(Arguments $arguments): void {
        $this->logger->info("Create like article command started");

        $article = new UUID($arguments->get('article_uuid'));
        $user = new UUID($arguments->get('user_uuid'));

        if(!$this->userExist($user)) {
            $this->logger->warning("Cannot get user: $user");
            throw new CommandException("Cannot get user: $user");
        }
        elseif (!$this->articleExist($article)) {
            $this->logger->warning("Cannot get article: $article");
            throw new CommandException("Cannot get article: $article");
        }

        $uuid = UUID::random();
        $this->likeArticleRepository->save(new LikeArticle(
            $uuid,
            $article,
            $user
        ));

        $this->logger->info("Like article created: $uuid");
    }

    public function userExist(UUID $authorUuid): bool
    {
        try {
            $this->userRepository->get($authorUuid);
        } catch (UserNotFoundException $e) {
            return false;
        }

        return true;
    }

    public function articleExist(UUID $articleUuid): bool
    {
        try {
            $this->articleRepository->get($articleUuid);
        } catch (ArticleNotFoundException $e) {
            return false;
        }

        return true;
    }
}