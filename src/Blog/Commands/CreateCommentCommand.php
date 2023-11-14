<?php

namespace Galim\Itrvb\Blog\Commands;

use Galim\Itrvb\Blog\Comment;
use Galim\Itrvb\Blog\Repositories\CommentRepository\CommentRepositoryInterface;
use Galim\Itrvb\Blog\UUID;

class CreateCommentCommand {
    public function __construct(private CommentRepositoryInterface $commentRepository) {

    }

    public function handle(Arguments $arguments): void {
        $this->commentRepository->save(new Comment(
            UUID::random(),
            new UUID($arguments->get('author_uuid')),
            new UUID($arguments->get('article_uuid')),
            $arguments->get('texts')
        ));
    }
}