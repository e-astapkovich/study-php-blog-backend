<?php

namespace Eastap\PhpBlog;

use Eastap\PhpBlog\Container\DIContainer;
use Eastap\PhpBlog\Interfaces\CommentRepositoryInterface;
use Eastap\PhpBlog\Interfaces\PostRepositoryInterface;
use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\Interfaces\LikeRepositoryInterface;
use Eastap\PhpBlog\Repositories\SqliteCommentRepository;
use Eastap\PhpBlog\Repositories\SqlitePostRepository;
use Eastap\PhpBlog\Repositories\SqliteUserRepository;
use Eastap\PhpBlog\Repositories\SqliteLikeRepository;
use PDO;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;
use Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$container = new DIContainer;

Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();

$container->bind(
    PDO::class,
    new PDO('sqlite:' . __DIR__ . '/blog.sqlite', null, null, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ])
);

$container->bind(
    LoggerInterface::class,
    (new Logger('blog'))
        ->pushHandler(new StreamHandler(
            __DIR__ . '/logs/blog.log'
        ))
        ->pushHandler(new StreamHandler(
            __DIR__ . '/logs/blog.error.log',
            Level::Error,
            bubble: false
        ))
        ->pushHandler(new StreamHandler("php://stdout"))
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

$container->bind(
    LikeRepositoryInterface::class,
    SqliteLikeRepository::class
);

return $container;
