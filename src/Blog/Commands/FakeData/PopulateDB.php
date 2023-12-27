<?php

namespace Galim\Itrvb\Blog\Commands\FakeData;

use Faker\Generator;
use Galim\Itrvb\Blog\Article;
use Galim\Itrvb\Blog\Comment;
use Galim\Itrvb\Blog\Name;
use Galim\Itrvb\Blog\Repositories\ArticleRepository\ArticleRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\CommentRepository\CommentRepositoryInterface;
use Galim\Itrvb\Blog\Repositories\UserRepository\UserRepositoryInterface;
use Galim\Itrvb\Blog\User;
use Galim\Itrvb\Blog\UUID;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateDB extends Command {
    public function __construct(
        private Generator $faker,
        private UserRepositoryInterface $userRepository,
        private ArticleRepositoryInterface $articleRepository,
        private CommentRepositoryInterface $commentRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('fake-data:populate-db')
            ->setDescription('Populates DB with fake data')
            ->addArgument('count', InputArgument::REQUIRED, 'Count');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = [];
        $articles = [];

        for ($i = 0; $i < $input->getArgument('count'); $i++) {
            $user = $this->createFakeUser();
            $users[] = $user;
            $output->writeln('User created: ' . $user->getUsername());
        }

        foreach ($users as $user) {
            $article = $this->createFakeArticle($user);
            $articles[] = $article;
            $output->writeln('Article created: ' . $article->getTitle());
        }

        foreach ($users as $user) {
            foreach ($articles as $article) {
                $comment = $this->createFakeComment($user, $article);
                $output->writeln('Comment created: ' . $comment->getTexts());
            }
        }

        return Command::SUCCESS;
    }

    private function createFakeUser(): User {
        $user = User::createFrom(
            $this->faker->userName(),
            new Name($this->faker->firstNameMale(), $this->faker->lastName())
        );

        $this->userRepository->save($user);

        return $user;
    }

    private function createFakeArticle(User $user): Article {
        $article = new Article(
            UUID::random(),
            $user->getUuid(),
            $this->faker->realText(10),
            $this->faker->realText(100)
        );

        $this->articleRepository->save($article);

        return $article;
    }

    private function createFakeComment(User $user, Article $article): Comment {
        $comment = new Comment(
            UUID::random(),
            $user->getUuid(),
            $article->getUuid(),
            $this->faker->realText(100)
        );

        $this->commentRepository->save($comment);

        return $comment;
    }
}