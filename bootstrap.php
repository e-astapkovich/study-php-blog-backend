<?php

namespace Eastap\PhpBlog;

use Eastap\PhpBlog\Container\DIContainer;
use Eastap\PhpBlog\Interfaces\CommentRepositoryInterface;
use Eastap\PhpBlog\Interfaces\PostRepositoryInterface;
use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\Repositories\SqliteCommentRepository;
use Eastap\PhpBlog\Repositories\SqlitePostRepository;
use Eastap\PhpBlog\Repositories\SqliteUserRepository;
use PDO;

require_once __DIR__ . '/vendor/autoload.php';

$container = new DIContainer;

$container->bind(
    PDO::class,
    new PDO('sqlite:' . __DIR__ . 'blog.sqlite', null, null, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ])
);

$container->bind(
    UserRepositoryInterface::class,
    SqliteUserRepository::class
);

$container->bind(
    PostRepositoryInterface::class,
    SqlitePostRepository::class
);

$container->bind(
    CommentRepositoryInterface::class,
    SqliteCommentRepository::class
);

return $container;
