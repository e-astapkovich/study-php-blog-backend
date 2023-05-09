<?php

//ДЛЯ СОЗДАНИЯ И ТЕСТОВОГО ЗАПОЛНЕНИЯ БД, ЗАПУСТИТЬ ФАЙЛ createDB.php

namespace Eastap\PhpBlog\Blog;

use Eastap\PhpBlog\Exceptions\AppException;
use Eastap\PhpBlog\Repositories\SqlitePostRepository;
use Eastap\PhpBlog\Repositories\SqliteCommentRepository;
use Eastap\PhpBlog\Repositories\SqliteUserRepository;
use Eastap\PhpBlog\UUID;
use \PDO;

require_once __DIR__ . '/vendor/autoload.php';

$faker = \Faker\Factory::create();

$pdo = new PDO('sqlite:blog.sqlite', null, null, [
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$userRepo = new SqliteUserRepository($pdo);

// $pirate = new User(UUID::random(), 'pirate', 'Billy', 'Bons');
// $repo->save($pirate);

try {
  // echo $repo->get(new UUID('3bed1a29-6737-45ff-81f2-7366f56498a7'));
echo $userRepo->getByLogin('pirate') . PHP_EOL;
} catch (AppException $e) {
  echo "пользователь не найден";
}

$postRepo = new SqlitePostRepository($pdo);

try {
  echo $postRepo->get(new UUID('881a75e6-5db9-4106-bb1c-94a84058594f')) . PHP_EOL;
} catch (AppException $e) {
  echo $e->getMessage();
}

$commentRepo = new SqliteCommentRepository($pdo);

try {
  echo $commentRepo->get(new UUID('616f7121-89d0-4f38-b356-31746394d41a')) . PHP_EOL;
} catch (AppException $e) {
  echo $e->getMessage();
}





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
