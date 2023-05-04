<?php

namespace Eastap\PhpBlog\Blog;

use \PDO;

require_once __DIR__ . '/vendor/autoload.php';

$faker = \Faker\Factory::create();

$pdo = new PDO('sqlite:blog.sqlite', null, null, [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// switch($argv[1]) {
//   case 'user':
//     print new User(
//         $faker->word(),
//         $faker->firstName(null),
//         $faker->lastName(null)
//       );
//     break;

//     case 'post':
//       print new Post(
//           $faker->unique()->numberBetween(1, 1000),
//           new User(
//             $faker->word(),
//             $faker->firstName(null),
//             $faker->lastName(null)
//           ),
//           $faker->sentence(rand(1, 5)),
//           $faker->paragraph(rand(2, 5))
//         );
//       break;

//       case 'comment':
//         print new Comment(
//             $faker->unique()->numberBetween(1, 1000),
//             $faker->unique()->numberBetween(1, 1000),
//             $faker->unique()->numberBetween(1, 1000),
//             $faker->paragraph(rand(1, 3))
//           );
//         break;
// }
