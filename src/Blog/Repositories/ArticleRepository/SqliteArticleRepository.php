<?php

namespace Galim\Itrvb\Blog\Repositories\ArticleRepository;

use Galim\Itrvb\Blog\Article;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\UUID;
use PDO;

class SqliteArticleRepository implements ArticleRepositoryInterface {
    public function __construct(private PDO $connection){

    }

    public function save(Article $article): void {
        $statement = $this->connection->prepare(
            'INSERT INTO article (uuid, author_uuid, title, texts) VALUES (:uuid, :author_uuid, :title, :texts)'
        );
        $statement->execute([
            ':uuid' => (string)$article->getUuid(),
            ':author_uuid' => $article->getAuthorUuid(),
            ':title' => $article->getTitle(),
            ':texts' => $article->getTexts()
        ]);
    }

    public function get(UUID $uuid): Article {
        $statement = $this->connection->prepare(
            'SELECT * FROM article WHERE uuid = :uuid'
        );
        $statement->execute([
            ':uuid' => (string)$uuid
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result === false) {
            throw new UserNotFoundException(
                "Cannot get article: $uuid"
            );
        }

        return new Article(
            new UUID($result['uuid']),
            $result['author_uuid'],
            $result['title'],
            $result['texts']);
    }
}