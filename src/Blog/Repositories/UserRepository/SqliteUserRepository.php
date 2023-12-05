<?php
namespace Galim\Itrvb\Blog\Repositories\UserRepository;

use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Name;
use Galim\Itrvb\Blog\UUID;
use PDO;
use PDOStatement;
use Galim\Itrvb\Blog\User;

class SqliteUserRepository implements UserRepositoryInterface {
    public function __construct(private PDO $connection){

    }

    public function save(User $user): void {
        $statement = $this->connection->prepare(
            'INSERT INTO users (uuid, username, first_name, last_name) VALUES (:uuid, :username, :first_name, :last_name)'
        );
        $statement->execute([
            ':uuid' => (string)$user->getUuid(),
            ':username' => $user->getUsername(),
            ':first_name' => $user->getName()->getFirstName(),
            ':last_name' => $user->getName()->getLastName()
        ]);
    }

    public function get(UUID $uuid): User {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE uuid = :uuid'
        );
        $statement->execute([
            ':uuid' => (string)$uuid,
        ]);

        return $this->getUser($statement, (string)$uuid);
    }

    public function getByUsername(string $username): User {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE username = :username'
        );
        $statement->execute([
            ':username' => $username
        ]);

        return $this->getUser($statement, $username);
    }

    private function getUser(PDOStatement $statement, string $payload) {
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if($result === false) {
            throw new UserNotFoundException(
                "Cannot get user: $payload"
            );
        }

        return new User(
            new UUID($result['uuid']),
            $result['username'],
            new Name($result['first_name'], $result['last_name']));
    }
}