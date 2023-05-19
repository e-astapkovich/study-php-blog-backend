<?php

namespace Eastap\PhpBlog\Container;

use Eastap\PhpBlog\Exceptions\NotFoundException;

class DIContainer
{
    public function get(string $type): object {
        throw new NotFoundException("Cannot resolve type: $type");
    }
}
