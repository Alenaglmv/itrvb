<?php

use Galim\Itrvb\Blog\Container\DIContainer;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\SqliteArticleRepository;
use Galim\Itrvb\Blog\Repositories\CommentRepository\CommentRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\CommentRepository\SqliteCommentRepository;
use Galim\Itrvb\Blog\Repositories\LikeArticleRepository\LikeArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\LikeArticleRepository\SqliteLikeArticleRepository;
use Galim\Itrvb\Blog\Repositories\UserRepository\SqliteUserRepository;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;

require_once __DIR__ . '/vendor/autoload.php';

$container = new DIContainer;

$container->bind(PDO::class, new PDO('sqlite:' . __DIR__ . '/blog.sqlite'));
$container->bind(UserRepositoryInterface::class, SqliteUserRepository::class);
$container->bind(ArticleRepositoryInterface::class, SqliteArticleRepository::class);
$container->bind(CommentRepositoryInterface::class, SqliteCommentRepository::class);
$container->bind(LikeArticleRepositoryInterface::class, SqliteLikeArticleRepository::class);

return $container;
