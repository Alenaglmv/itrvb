<?php

namespace Galim\Itrvb\Blog\Repositories\CommentRepository;

use Galim\Itrvb\Blog\Comment;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\UUID;
use PDO;

class SqliteCommentRepository implements CommentRepositoryInterface {
    public function __construct(private PDO $connection){

    }

    public function save(Comment $comment): void {
        $statement = $this->connection->prepare(
            'INSERT INTO comment (uuid, author_uuid, article_uuid, texts) VALUES (:uuid, :author_uuid, :article_uuid, :texts)'
        );
        $statement->execute([
            ':uuid' => (string)$comment->getUuid(),
            ':author_uuid' => $comment->getAuthorUuid(),
            ':article_uuid' => $comment->getArticleUuid(),
            ':texts' => $comment->getTexts()
        ]);
    }

    public function get(UUID $uuid): Comment {
        $statement = $this->connection->prepare(
            'SELECT * FROM comment WHERE uuid = :uuid'
        );
        $statement->execute([
            ':uuid' => (string)$uuid
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result === false) {
            throw new UserNotFoundException(
                "Cannot get comment: $uuid"
            );
        }

        return new Comment(
            new UUID($result['uuid']),
            $result['author_uuid'],
            $result['article_uuid'],
            $result['texts']);
    }
}