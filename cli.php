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
print $user->getId() . PHP_EOL;;
print $user->getFirstName() . PHP_EOL;;
print $user->getLastName() . PHP_EOL;;
