<?php

use Galim\Itrvb\Blog\Commands\CreateArticleCommand;
use Galim\Itrvb\Blog\Commands\CreateCommentCommand;
use Galim\Itrvb\Blog\Repositories\CommentRepository\SqliteCommentRepository;
use Galim\Itrvb\Blog\Repositories\UserRepository\SqliteUserRepository;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\SqliteArticleRepository;
use Galim\Itrvb\Blog\Commands\CreateUserCommand;
use Galim\Itrvb\Blog\Exceptions\CommandException;
use Galim\Itrvb\Blog\Commands\Arguments;

require './vendor/autoload.php';

$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

//USER

//$userRepository = new SqliteUserRepository($connection);
//$commandUser = new CreateUserCommand($userRepository);
//try {
//    $commandUser->handle(Arguments::fromArgv($argv));
//}
//catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}

//ARTICLE

//$articleRepository = new SqliteArticleRepository($connection);
//$commandArticle = new CreateArticleCommand($articleRepository);
//try {
//    $commandArticle->handle(Arguments::fromArgv($argv));
//}
//catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}

//COMMENT

$commentRepository = new SqliteCommentRepository($connection);
$commandComment = new CreateCommentCommand($commentRepository);

try {
    $commandComment->handle(Arguments::fromArgv($argv));
}
catch (CommandException $error) {
    echo "{$error->getMessage()}\n";
}

