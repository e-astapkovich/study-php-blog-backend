<?php

namespace Eastap\PhpBlog;

use Eastap\PhpBlog\Exceptions\AppException;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\SuccessResponse;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Http\Actions\FindPostByUuid;
use Eastap\PhpBlog\Http\Actions\FindByLogin;
use Eastap\PhpBlog\Repositories\SqlitePostRepository;
use Eastap\PhpBlog\Repositories\SqliteUserRepository;
use PDO;

require_once __DIR__ . '/vendor/autoload.php';

$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input')
);

// print_r($request->JsonBody());
// echo $request->JsonBodyField($_GET['field']);

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
        '/users/show' => new FindByLogin(
            new SqliteUserRepository(
                new PDO('sqlite:blog.sqlite', null, null, [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ])
            )
        ),
        '/posts/show' => new FindPostByUuid(
            new SqlitePostRepository(
                new PDO('sqlite:blog.sqlite', null, null, [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ])
            ),
            new SqliteUserRepository(
                new PDO('sqlite:blog.sqlite', null, null, [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ])
            )
        )
    ],
    'POST' => [
        '/users/create' => null,
        '/posts/create' => null,
    ]
];

if (!array_key_exists($method, $routes)) {
    (new ErrorResponse("Method is not defined: $method"))->send();
}

if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse("Path is not defined: $path"))->send();
};

$action = $routes[$method][$path];

try {
    $response = $action->handle($request);
} catch (AppException $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();
