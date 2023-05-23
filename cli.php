<?php
//ДЛЯ СОЗДАНИЯ И ТЕСТОВОГО ЗАПОЛНЕНИЯ БД, ЗАПУСТИТЬ ФАЙЛ createDB.php

use Eastap\PhpBlog\Commands\CreateUserCommand;
use Eastap\PhpBlog\Commands\Arguments;
use Eastap\PhpBlog\Exceptions\AppException;

require_once __DIR__ . '/bootstrap.php';

$command = $container->get(CreateUserCommand::class);

try {
  $command->handle(Arguments::fromArgv($argv));
} catch (AppException $e) {
  echo "{$e->getMessage()}\n";
}
