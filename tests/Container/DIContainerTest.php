<?php

namespace Eastap\PhpBlog\UnitTests\Container;

use PHPUnit\Framework\TestCase;
use Eastap\PhpBlog\Container\DIContainer;
use Eastap\PhpBlog\Exceptions\NotFoundException;

class DIContainerTest extends TestCase
{
    public function testItThrowsAnExceptionIfCannotResolveType(): void {
        $container = new DIContainer();

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(
            'Cannot resolve type: Eastap\PhpBlog\UnitTests\Container\SomeClass'
        );

        $container->get(SomeClass::class);
    }
}
