<?php

namespace Galim\Itrvb\Blog\Repositories\LikeArticleRepository;

use Galim\Itrvb\Blog\Exceptions\CommandException;
use Galim\Itrvb\Blog\UUID;
use PDO;
use Galim\Itrvb\Blog\LikeArticle;

class SqliteLikeArticleRepository implements LikeArticleRepositoryInterface {
    public function __construct(private PDO $connection){

    }

    public function save(LikeArticle $likeArticle): void {
        $result = $this->getByArticleAndUser($likeArticle->getArticleUuid(), $likeArticle->getUserUuid());

        if ($result){
            throw new CommandException("User has already liked this article");
        }

        $statement = $this->connection->prepare(
            'INSERT INTO likeArticle (uuid, article_uuid, user_uuid) VALUES (:uuid, :article_uuid, :user_uuid)'
        );
        $statement->execute([
            ':uuid' => (string)$likeArticle->getUuid(),
            ':article_uuid' => $likeArticle->getArticleUuid(),
            ':user_uuid' => $likeArticle->getUserUuid(),
        ]);
    }

    public function getByArticleUuid(UUID $article_uuid): array {
        $statement = $this->connection->prepare(
            'SELECT * FROM likeArticle WHERE article_uuid = :article_uuid'
        );
        $statement->execute([
            ':article_uuid' => (string)$article_uuid
        ]);

        $likesArticle = [];

        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            $likesArticle[] = new LikeArticle(
                new UUID($result['uuid']),
                new UUID($result['article_uuid']),
                new UUID($result['user_uuid'])
            );
        }

        return $likesArticle;
    }

    public function getByArticleAndUser(UUID $article_uuid, UUID $user_uuid): array {
        $statement = $this->connection->prepare(
            'SELECT * FROM likeArticle WHERE article_uuid = :article_uuid and user_uuid = :user_uuid'
        );
        $statement->execute([
            ':article_uuid' => (string)$article_uuid,
            ':user_uuid' => (string)$user_uuid
        ]);

        $likesArticle = [];

        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            $likesArticle[] = new LikeArticle(
                new UUID($result['uuid']),
                new UUID($result['article_uuid']),
                new UUID($result['user_uuid'])
            );
        }

        return $likesArticle;
    }
}