<?php

namespace Galim\Itrvb\Blog\Http\Actions\Articles;

use Galim\Itrvb\Blog\Exceptions\HttpException;
use Galim\Itrvb\Blog\Exceptions\UserNotFoundException;
use Galim\Itrvb\Blog\Http\Actions\ActionInterface;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Http\Response;

use Galim\Itrvb\Blog\Http\ErrorResponse;
use Galim\Itrvb\Blog\Http\SuccessfulResponse;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\UUID;

class DeleteArticle implements ActionInterface
{
    public function __construct(private ArticleRepositoryInterface $articleRepository) {

    }

    public function handle(Request $request): Response
    {
        try {
            $uuid = new UUID($request->query('uuid'));
        } catch (HttpException $error) {
            return new ErrorResponse($error->getMessage());
        }

        try {
            $this->articleRepository->delete($uuid);
            return new SuccessfulResponse([
                'uuid' => (string)$uuid,
            ]);
        } catch (HttpException $error) {
            return new ErrorResponse($error->getMessage());
        }
    }
}