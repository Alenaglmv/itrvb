<?php

use Galim\Itrvb\Blog\Exceptions\HttpException;
use Galim\Itrvb\Blog\Http\Actions\Articles\CreateArticle;
use Galim\Itrvb\Blog\Http\Actions\Articles\DeleteArticle;
use Galim\Itrvb\Blog\Http\Actions\Comments\CreateComment;
use Galim\Itrvb\Blog\Http\Actions\LikeArticle\CreateLikeArticle;
use Galim\Itrvb\Blog\Http\Actions\Users\CreateUser;
use Galim\Itrvb\Blog\Http\Actions\Users\FindByUsername;
use Galim\Itrvb\Blog\Http\ErrorResponse;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\SqliteArticleRepository;
use Galim\Itrvb\Blog\Repositories\CommentRepository\SqliteCommentRepository;
use Galim\Itrvb\Blog\Repositories\UserRepository\SqliteUserRepository;

$container = require __DIR__ . '/bootstrap.php';

$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));

try {
    $path = $request->path() ;
} catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}
try {
    $method = $request->method();
} catch (HttpException) {
    (new ErrorResponse)->send();
    return;
}

$routes = [
    'GET' => [
        '/users/show' => FindByUsername::class,
    ],
    'POST' => [
        '/users/create' => CreateUser::class,
        '/articles/create' => CreateArticle::class,
        '/articles/comments/create' => CreateComment::class,
        '/articles/likes/create' => CreateLikeArticle::class,
    ],
    'DELETE' => [
        '/articles/delete' => DeleteArticle::class,
    ],
];

if (!array_key_exists($method, $routes) || !array_key_exists($path, $routes[$method])) {
    (new ErrorResponse("Route not found: $method $path"))->send();
    return;
}

$actionClassName = $routes[$method][$path];
$action = $container->get($actionClassName);

try {
    if (is_callable($action)) {
        $response = $action($_GET['uuid'] ?? '');
    } else {
        $response = $action->handle($request);
    }
} catch (Exception $error) {
    (new ErrorResponse($error->getMessage()))->send();
    return;
}

$response->send();