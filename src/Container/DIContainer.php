<?php

namespace Eastap\PhpBlog\Container;

use Eastap\PhpBlog\Exceptions\NotFoundException;

class DIContainer
{
    public function get(string $type): object {
        if (!class_exists($type)) {
            throw new NotFoundException("Cannot resolve type: $type");
        }

        return new $type;
    }
}
