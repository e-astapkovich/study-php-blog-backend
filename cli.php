<?php

namespace Eastap\PhpBlog\Blog;
// use \Eastap\PhpBlog\User\User;

require_once __DIR__ . '/vendor/autoload.php';

$faker = \Faker\Factory::create();

$user = new User(
  $faker->unique()->numberBetween(1, 1000),
  $faker->firstName(null),
  $faker->lastName(null)
);

print $user . PHP_EOL;
print PHP_EOL;
print $user->getId() . PHP_EOL;;
print $user->getFirstName() . PHP_EOL;;
print $user->getLastName() . PHP_EOL;;
print PHP_EOL;

$post = new Post(
  $faker->unique()->numberBetween(1, 1000),
  $user,
  $faker->sentence(rand(1, 5)),
  $faker->paragraph(rand(2, 5))
);

print $post . PHP_EOL;
print PHP_EOL;
print $post->getId() . PHP_EOL;
print $post->getAuthor() . PHP_EOL;
print $post->getTitle() . PHP_EOL;
print $post->getText() . PHP_EOL;

$comment = new Comment(
  $faker->unique()->numberBetween(1, 1000),
  $faker->unique()->numberBetween(1, 1000),
  $faker->unique()->numberBetween(1, 1000),
  $faker->paragraph(rand(1, 3))
);

print $comment . PHP_EOL;
print PHP_EOL;
print $comment->getId() . PHP_EOL;
print $comment->getPostId() . PHP_EOL;
print $comment->getUserId() . PHP_EOL;
print $comment->getText() . PHP_EOL;
