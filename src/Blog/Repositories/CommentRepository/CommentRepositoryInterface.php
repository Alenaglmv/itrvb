<?php

namespace Galim\Itrvb\Blog\Repositories\CommentRepository;

use Galim\Itrvb\Blog\Comment;
use Galim\Itrvb\Blog\UUID;

interface CommentRepositoryInterface {
    public function save(Comment $comment): void;
    public function get(UUID $uuid): Comment;
}