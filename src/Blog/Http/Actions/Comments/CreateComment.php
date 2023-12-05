<?php

namespace Galim\Itrvb\Blog\Http\Actions\Comments;

use Galim\Itrvb\Blog\Comment;
use Galim\Itrvb\Blog\Exceptions\HttpException;
use Galim\Itrvb\Blog\Http\Actions\ActionInterface;
use Galim\Itrvb\Blog\Http\Auth\IdentificationInterface;
use Galim\Itrvb\Blog\Http\ErrorResponse;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Http\Response;
use Galim\Itrvb\Blog\Http\SuccessfulResponse;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\CommentRepository\CommentRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\UUID;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository, private UserRepositoryInterface $userRepository, private ArticleRepositoryInterface $articleRepository) {

    }

    public function handle(Request $request): Response
    {
        $userUuid = new UUID($request->jsonBodyField('author_uuid'));
        $user = $this->userRepository->get($userUuid);

        $articleUuid = new UUID($request->jsonBodyField('article_uuid'));
        $article = $this->articleRepository->get($articleUuid);

        $newCommentUuid = UUID::random();

        try {
            $comment = new Comment(
                $newCommentUuid,
                $user->getUuid(),
                $article->getUuid(),
                $request->jsonBodyField('texts')
            );
        } catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->commentRepository->save($comment);

        return new SuccessfulResponse([
            'uuid' => (string)$newCommentUuid,
        ]);
    }
}