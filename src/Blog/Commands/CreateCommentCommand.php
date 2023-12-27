<?php

namespace Galim\Itrvb\Blog\Commands;

use Galim\Itrvb\Blog\Comment;
use Galim\Itrvb\Blog\Exceptions\ArticleNotFoundException;
use Galim\Itrvb\Blog\Exceptions\CommandException;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\CommentRepository\CommentRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\UUID;
use Psr\Log\LoggerInterface;

class CreateCommentCommand {
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private UserRepositoryInterface $userRepository,
        private ArticleRepositoryInterface $articleRepository,
        private LoggerInterface $logger) {

    }

    public function handle(Arguments $arguments): void {
        $this->logger->info("Create comment command started");

        $user = new UUID($arguments->get('author_uuid'));
        $article = new UUID($arguments->get('article_uuid'));

        if(!$this->userExist($user)) {
            $this->logger->warning("Cannot get user: $user");
            throw new CommandException("Cannot get user: $user");
        }
        elseif (!$this->articleExist($article)) {
            $this->logger->warning("Cannot get article: $article");
            throw new CommandException("Cannot get article: $article");
        }

        $uuid = UUID::random();
        $this->commentRepository->save(new Comment(
            $uuid,
            $user,
            $article,
            $arguments->get('texts')
        ));

        $this->logger->info("Comment created: $uuid");
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