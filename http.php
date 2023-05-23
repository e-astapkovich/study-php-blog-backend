<?php

namespace Eastap\PhpBlog;

use Eastap\PhpBlog\Exceptions\AppException;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Http\Actions\Post\FindPostByUuid;
use Eastap\PhpBlog\Http\Actions\Post\CreatePost;
use Eastap\PhpBlog\Http\Actions\Post\DeletePost;
use Eastap\PhpBlog\Http\Actions\User\FindByLogin;
use Eastap\PhpBlog\Http\Actions\Comment\CreateComment;

require_once __DIR__ . '/bootstrap.php';

$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input')
);

try {
    $method = $request->method();
} catch (HttpException $e) {
    (new ErrorResponse($e->getMessage()))->send();
    return;
}

try {
    $path = $request->path();
} catch (HttpException $e) {
    (new ErrorResponse($e->getMessage()))->send();
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
    ],
    'DELETE' => [
        '/posts' => DeletePost::class
    ]
];

if (!array_key_exists($method, $routes)) {
    (new ErrorResponse("Method is not defined: $method"))->send();
}

if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse("Path is not defined: $path"))->send();
};

$action = $container->get($routes[$method][$path]);

try {
    $response = $action->handle($request);
} catch (AppException $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();
