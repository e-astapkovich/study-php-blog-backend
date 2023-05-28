<?php

namespace Eastap\PhpBlog;

use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Http\Actions\Post\FindPostByUuid;
use Eastap\PhpBlog\Http\Actions\Post\CreatePost;
use Eastap\PhpBlog\Http\Actions\Post\DeletePost;
use Eastap\PhpBlog\Http\Actions\User\FindByLogin;
use Eastap\PhpBlog\Http\Actions\Comment\CreateComment;
use Eastap\PhpBlog\Http\Actions\Likes\AddLike;
use Exception;
use Psr\Log\LoggerInterface;

require_once __DIR__ . '/bootstrap.php';

$logger = $container->get(LoggerInterface::class);
$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input')
);

try {
    $method = $request->method();
} catch (HttpException $e) {
    $logger->warning($e->getMessage());
    (new ErrorResponse)->send();
    return;
}

try {
    $path = $request->path();
} catch (HttpException $e) {
    $logger->warning($e->getMessage());
    (new ErrorResponse)->send();
    return;
}

$routes = [
    'GET' => [
        '/users/show' => FindByLogin::class,
        '/posts/show' => FindPostByUuid::class
    ],
    'POST' => [
        '/posts/create' => CreatePost::class,
        '/comments/create' => CreateComment::class,
        '/likes/add' => AddLike::class
    ],
    'DELETE' => [
        '/posts' => DeletePost::class
    ]
];

if (!array_key_exists($method, $routes)) {
    $logger->notice("Method is not defined: $method");
    (new ErrorResponse("Method is not defined: $method"))->send();
    return;
}

if (!array_key_exists($path, $routes[$method])) {
    $logger->notice("Path is not defined: $path");
    (new ErrorResponse("Path is not defined: $path"))->send();
    return;
};

try {
    $action = $container->get($routes[$method][$path]);
    $response = $action->handle($request);
} catch (Exception $e) {
    $logger->error($e->getMessage());
    (new ErrorResponse)->send();
    return;
}

$response->send();
