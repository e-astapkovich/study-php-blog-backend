<?php

//ДЛЯ СОЗДАНИЯ И ТЕСТОВОГО ЗАПОЛНЕНИЯ БД, ЗАПУСТИТЬ ФАЙЛ createDB.php

// namespace Eastap\PhpBlog\Blog;

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
$postRepo = new SqlitePostRepository($pdo);
$commentRepo = new SqliteCommentRepository($pdo);

try {
  echo $postRepo->get(new UUID('881a75e6-5db9-4106-bb1c-94a84058594f')) . PHP_EOL;
} catch (AppException $e) {
  echo $e->getMessage();
}

try {
  echo $commentRepo->get(new UUID('616f7121-89d0-4f38-b356-31746394d41a')) . PHP_EOL;
} catch (Exception $e) {
  echo $e->getMessage();
}
