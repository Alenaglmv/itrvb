<?php

use Galim\Itrvb\Blog\Exceptions\HttpException;
use Galim\Itrvb\Blog\Http\Actions\Articles\CreateArticle;
use Galim\Itrvb\Blog\Http\Actions\Articles\DeleteArticle;
use Galim\Itrvb\Blog\Http\Actions\Comments\CreateComment;
use Galim\Itrvb\Blog\Http\Actions\Users\CreateUser;
use Galim\Itrvb\Blog\Http\Actions\Users\FindByUsername;
use Galim\Itrvb\Blog\Http\ErrorResponse;
use Galim\Itrvb\Blog\Http\Request;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\SqliteArticleRepository;
use Galim\Itrvb\Blog\Repositories\CommentRepository\SqliteCommentRepository;
use Galim\Itrvb\Blog\Repositories\UserRepository\SqliteUserRepository;

require_once __DIR__.'/vendor/autoload.php';

$pdo = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

$userRepository = new SqliteUserRepository($pdo);
$articleRepository = new SqliteArticleRepository($pdo);
$commentRepository = new SqliteCommentRepository($pdo);

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
        '/users/show' => new FindByUsername($userRepository),
    ],
    'POST' => [
        '/users/create' => new CreateUser($userRepository),
        '/articles/create' => new CreateArticle($articleRepository, $userRepository),
        '/articles/comments/create' => new CreateComment($commentRepository, $userRepository, $articleRepository),
    ],
    'DELETE' => [
        '/articles/delete' => new DeleteArticle($articleRepository),
    ],
];

if (!array_key_exists($method, $routes) || !array_key_exists($path, $routes[$method])) {
    (new ErrorResponse("Route not found: $method $path"))->send();
    return;
}

$action = $routes[$method][$path];

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