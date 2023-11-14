<?php

namespace Galim\Itrvb\Blog\Commands;

use Galim\Itrvb\Blog\Article;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\UUID;

class CreateArticleCommand {
    public function __construct(private ArticleRepositoryInterface $articleRepository) {

    }

    public function handle(Arguments $arguments): void {
        $this->articleRepository->save(new Article(
            UUID::random(),
            new UUID($arguments->get('author_uuid')),
            $arguments->get('title'),
            $arguments->get('texts')
        ));
    }
}