<?php

namespace Galim\Itrvb\Blog\Repositories\ArticleRepository;

use Galim\Itrvb\Blog\Article;
use Galim\Itrvb\Blog\UUID;

interface ArticleRepositoryInterface {
    public function save(Article $article): void;
    public function get(UUID $uuid): Article;
}