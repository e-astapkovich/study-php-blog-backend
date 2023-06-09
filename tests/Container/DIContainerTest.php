<?php

namespace Eastap\PhpBlog\UnitTests\Container;

use PHPUnit\Framework\TestCase;
use Eastap\PhpBlog\Container\DIContainer;
use Eastap\PhpBlog\Exceptions\NotFoundException;
use Eastap\PhpBlog\Interfaces\UserRepositoryInterface;
use Eastap\PhpBlog\Repositories\InMemoryUserRepository;

class DIContainerTest extends TestCase
{
    public function testItThrowsAnExceptionIfCannotResolveType(): void
    {
        $container = new DIContainer();

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(
            'Cannot resolve type: Eastap\PhpBlog\UnitTests\Container\SomeClass'
        );

        $container->get(SomeClass::class);
    }

    public function testItResolvesClassWithoutDependecies(): void
    {
        $container = new DIContainer();
        $object = $container->get(SomeClassWithoutDependencies::class);

        $this->assertInstanceOf(
            SomeClassWithoutDependencies::class,
            $object
        );
    }

    public function testItResolvesClassByContract(): void
    {
        $container = new DIContainer();

        $container->bind(
            UserRepositoryInterface::class,
            InMemoryUserRepository::class
        );

        $object = $container->get(UserRepositoryInterface::class);
        $this->assertInstanceOf(
            InMemoryUserRepository::class,
            $object
        );
    }

    public function testItReturnsPredefinedObject(): void
    {
        $container = new DIContainer();

        $container->bind(
            SomeClassWithParameter::class,
            new SomeClassWithParameter(42)
        );

        $object =  $container->get(SomeClassWithParameter::class);

        $this->assertInstanceOf(
            SomeClassWithParameter::class,
            $object
        );

        $this->assertSame(
            42,
            $object->value
        );
    }

    public function testItResolvesClassWithDependencies(): void {
        $container = new DIContainer;

        $container->bind(
            SomeClassWithParameter::class,
            new SomeClassWithParameter(42)
        );

        $object = $container->get(ClassDependingOnAnother::class);

        $this->assertInstanceOf(
            ClassDependingOnAnother::class,
            $object
        );
    }
}
