<?php

namespace Galim\Itrvb\Blog\Repositories\LikeArticleRepository;

use Galim\Itrvb\Blog\LikeArticle;
use Galim\Itrvb\Blog\UUID;

interface LikeArticleRepositoryInterface {
    public function save(LikeArticle $likeArticle): void;
    public function getByArticleUuid(UUID $article_uuid): array;
    public function getByArticleAndUser(UUID $article_uuid, UUID $user_uuid): array;
}