<?php

namespace Eastap\PhpBlog\Exceptions;

use Eastap\PhpBlog\Exceptions\AppException;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends AppException implements NotFoundExceptionInterface
{

}
