<?php

namespace Eastap\PhpBlog\UnitTests\Container;

class ClassDependingOnAnother
{
    public function __construct(
        SomeClassWithoutDependencies $one,
        SomeClassWithParameter $two
    ) {
    }
}
