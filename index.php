<?php

use Galim\Itrvb\Blog\Article;
use Galim\Itrvb\Blog\Comment;
use Galim\Itrvb\Blog\User;
use Galim\Itrvb\Blog\Name;

require './vendor/autoload.php';

$faker = Faker\Factory::create('ru_RU');

$name = new Name($faker->firstName(), $faker->lastName());

$user= new User($faker->unique()->randomNumber, $name);
echo "<b>Пользователь:</b> " . "<br>" . $user . "<br>";

$article = new Article($faker->unique()->randomNumber, $user->id, $faker->sentence, $faker->text());
echo "<b>Статья</b> : " . "<br>" . $article . "<br>";

$comment = new Comment($faker->unique()->randomNumber, $user->id, $article->id, $faker->text());
echo "<b>Комментарий</b> : " . "<br>" . $comment . "<br>";
