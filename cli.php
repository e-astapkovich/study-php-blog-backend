<?php

namespace Eastap\PhpBlog\Blog;
// use \Eastap\PhpBlog\User\User;

require_once __DIR__ . '/vendor/autoload.php';

$faker = \Faker\Factory::create();

$user = new User(
  $faker->firstName(null),
  $faker->lastName(null)
);

print $user;
