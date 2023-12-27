<?php

namespace Galim\Itrvb\Blog\Commands;

use Galim\Itrvb\Blog\Article;
use Galim\Itrvb\Blog\Exceptions\CommandException;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateArticleCommand {
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
        private UserRepositoryInterface $userRepository,
        private LoggerInterface $logger) {

    }

    public function handle(Arguments $arguments): void {
        $this->logger->info("Create article command started");

        $user = new UUID($arguments->get('author_uuid'));

        if(!$this->userExist($user)) {
            $this->logger->warning("Cannot get user: $user");
            throw new CommandException("Cannot get user: $user");
        }

        $uuid = UUID::random();
        $this->articleRepository->save(new Article(
            $uuid,
            $user,
            $arguments->get('title'),
            $arguments->get('texts')
        ));

        $this->logger->info("Article created: $uuid");
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
}