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

$request = new Request($_GET, $_SERVER);

try {
    $path = $request->path();
} catch (HttpException $e) {
    (new ErrorResponse)->send();
    return;
}

$routes = [
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
];

// $action = new FindByLogin(
//     new SqliteUserRepository(
//         new PDO('sqlite:blog.sqlite', null, null, [
//             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//         ])
//     )
// );

// $action = new FindPostByUuid(
//     new SqlitePostRepository(
//         new PDO('sqlite:blog.sqlite', null, null, [
//             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//         ])
//     ),
//     new SqliteUserRepository(
//         new PDO('sqlite:blog.sqlite', null, null, [
//             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//         ])
//     )
// );

// $action->handle($request)->send();

if (!array_key_exists($path, $routes)) {
    (new ErrorResponse('Not found'))->send();
}

$action = $routes[$path];

try {
    $response = $action->handle($request);
} catch (AppException $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();
