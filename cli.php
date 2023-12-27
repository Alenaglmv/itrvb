<?php

use Galim\Itrvb\Blog\Commands\CreateArticleCommand;
use Galim\Itrvb\Blog\Commands\CreateCommentCommand;
use Galim\Itrvb\Blog\Commands\CreateLikeArticleCommand;
use Galim\Itrvb\Blog\Commands\CreateUserCommand;
use Galim\Itrvb\Blog\Commands\FakeData\PopulateDB;
use Galim\Itrvb\Blog\Exceptions\CommandException;
use Galim\Itrvb\Blog\Commands\Arguments;
use Symfony\Component\Console\Application;

$container = require __DIR__ . '/bootstrap.php';

$application = new Application();

$commandsClasses = [
    PopulateDB::class
];

foreach ($commandsClasses as $commandsClass) {
    $command = $container->get($commandsClass);

    $application->add($command);
}

$application->run();




//USER

//$commandUser = $container->get(CreateUserCommand::class);
//
//try {
//    $commandUser->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}


//ARTICLE

//$commandArticle = $container->get(CreateArticleCommand::class);
//
//try {
//    $commandArticle->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}


//COMMENT

//$commandComment = $container->get(CreateCommentCommand::class);
//
//try {
//    $commandComment->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}


//LIKE ARTICLE

//$commandLikeArticle = $container->get(CreateLikeArticleCommand::class);
//
//try {
//    $commandLikeArticle->handle(Arguments::fromArgv($argv));
//} catch (CommandException $error) {
//    echo "{$error->getMessage()}\n";
//}

