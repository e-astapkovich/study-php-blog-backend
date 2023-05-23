<?php

namespace Eastap\PhpBlog\UnitTests\Container;

class SomeClassWithParameter
{
    public function __construct(
        public int $value
    ) {
    }

    public function value():int {
        return $this->value;
    }
}
