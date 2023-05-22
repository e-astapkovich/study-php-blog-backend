<?php

namespace Eastap\PhpBlog\Container;

use Eastap\PhpBlog\Exceptions\NotFoundException;

class DIContainer
{
    private array $resolvers = [];

    public function bind(string $type, $resolver):void {
        $this->resolvers[$type] = $resolver;
    }

    public function get(string $type): object {

        if (array_key_exists($type, $this->resolvers)) {
            $typeToCreate = $this->resolvers[$type];
            if (is_object($typeToCreate)) {
                return $typeToCreate;
            }
            return $this->get($typeToCreate);
        }

        if (!class_exists($type)) {
            throw new NotFoundException("Cannot resolve type: $type");
        }

        return new $type;
    }
}
