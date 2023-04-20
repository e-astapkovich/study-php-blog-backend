<?php

use Eastap\PhpBlog\User\Name;

require_once __DIR__ . '/vendor/autoload.php';

$faker = Faker\Factory::create();

$name = new Name(
  $faker->firstName(null),
  $faker->lastName(null)
);

print $name;
