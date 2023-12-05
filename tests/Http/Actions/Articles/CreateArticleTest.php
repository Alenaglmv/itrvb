<?php

namespace Galim\Itrvb\Blog\UnitTests\Http\Actions\Articles;

use Galim\Itrvb\Blog\Exceptions\InvalidArgumentException;
use Galim\Itrvb\Blog\Http\Actions\Articles\CreateArticle;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Http\ErrorResponse;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Http\SuccessfulResponse;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\Name;
use Galim\Itrvb\Blog\User;
use Galim\Itrvb\Blog\UUID;

class CreateArticleTest extends TestCase {
    public function testSuccessResponse() {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->expects($this->once())
            ->method('get')
            ->willReturn(
                new User(UUID::random(), 'username', new Name('Alex', 'Alexin'))
            );

        $articleRepository = $this->createMock(ArticleRepositoryInterface::class);
        $articleRepository->expects($this->once())
            ->method('save');

        $createArticle = new CreateArticle($articleRepository, $userRepository);

        $request = new Request([], [], '{
            "author_uuid": "e6cba7b0-1aac-4ec5-8023-26cdb27a3576",
            "title": "Summer",
            "texts": "GoodWeather"
        }');

        $response = $createArticle->handle($request);
        $this->assertInstanceOf(SuccessfulResponse::class, $response);
    }

    public function testInvalidUuidFormat() {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $articleRepository = $this->createMock(ArticleRepositoryInterface::class);

        $createArticle = new CreateArticle($articleRepository, $userRepository);

        $request = new Request([], [], '{
            "author_uuid": "e6cba7b0-1aac-4ec5-8023-2",
            "title": "Summer",
            "texts": "GoodWeather"
        }');

        $this->expectException(InvalidArgumentException::class);
        $createArticle->handle($request);
    }

    public function testNotFoundUserByUuid() {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('get')->willThrowException(new UserNotFoundException());

        $articleRepository = $this->createMock(ArticleRepositoryInterface::class);

        $createArticle = new CreateArticle($articleRepository, $userRepository);

        $request = new Request([], [], '{
            "author_uuid": "e6cba7b0-1aac-4ec5-8023-26cdb27a3500",
            "title": "Summer",
            "texts": "GoodWeather"
        }');

        $this->expectException(UserNotFoundException::class);
        $createArticle->handle($request);
    }

    public function testNotAllData() {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $articleRepository = $this->createMock(ArticleRepositoryInterface::class);

        $createArticle = new CreateArticle($articleRepository, $userRepository);

        $request = new Request([], [], '{
            "author_uuid": "e6cba7b0-1aac-4ec5-8023-26cdb27a3576",
            "texts": "GoodWeather"
        }');

        $this->assertInstanceOf(ErrorResponse::class, $createArticle->handle($request));
        $this->expectOutputString('');
        $createArticle->handle($request);
    }
}