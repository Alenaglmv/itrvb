<?php

use Galim\Itrvb\Blog\Commands\FakeData\PopulateDB;
use Galim\Itrvb\Blog\Container\DIContainer;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\SqliteArticleRepository;
use Galim\Itrvb\Blog\Repositories\CommentRepository\CommentRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\CommentRepository\SqliteCommentRepository;
use Galim\Itrvb\Blog\Repositories\LikeArticleRepository\LikeArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\LikeArticleRepository\SqliteLikeArticleRepository;
use Galim\Itrvb\Blog\Repositories\UserRepository\SqliteUserRepository;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Monolog\Handler\FilterHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Faker\Generator;
use Faker\Provider\ru_RU\Person;
use Faker\Provider\ru_RU\Text;
use Faker\Provider\ru_RU\Internet;

require_once __DIR__ . '/vendor/autoload.php';

$faker = new Generator();
$faker->addProvider(new Person($faker));
$faker->addProvider(new Text($faker));
$faker->addProvider(new Internet($faker));

$container = new DIContainer;

$container->bind(PDO::class, new PDO('sqlite:' . __DIR__ . '/blog.sqlite'));
$container->bind(UserRepositoryInterface::class, SqliteUserRepository::class);
$container->bind(ArticleRepositoryInterface::class, SqliteArticleRepository::class);
$container->bind(CommentRepositoryInterface::class, SqliteCommentRepository::class);
$container->bind(LikeArticleRepositoryInterface::class, SqliteLikeArticleRepository::class);
$container->bind(LoggerInterface::class, (new Logger('blog'))
    ->pushHandler(new StreamHandler(__DIR__ . '/logs/blog.log'))
    ->pushHandler(new FilterHandler(new StreamHandler(__DIR__ . '/logs/blog.error.log'), LogLevel::ERROR))
    ->pushHandler(new StreamHandler('php://stdout'))
);
$container->bind(Generator::class, $faker);

return $container;
