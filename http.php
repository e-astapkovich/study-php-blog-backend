<?php

namespace Eastap\PhpBlog;

use Eastap\PhpBlog\Http\Actions\FindByLogin;
use Eastap\PhpBlog\Http\Request;
use Eastap\PhpBlog\Http\SuccessResponse;
use Eastap\PhpBlog\Http\ErrorResponse;
use Eastap\PhpBlog\Exceptions\HttpException;
use Eastap\PhpBlog\Repositories\SqliteUserRepository;
use PDO;

require_once __DIR__ . '/vendor/autoload.php';

$request = new Request($_GET, $_SERVER);

$action = new FindByLogin(
    new SqliteUserRepository(
        new PDO('sqlite:blog.sqlite', null, null, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ])
    )
);

$action->handle($request)->send();
