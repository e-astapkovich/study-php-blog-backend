<?php

namespace Eastap\PhpBlog\UnitTests\Commands;

use PHPUnit\Framework\TestCase;
use Eastap\PhpBlog\Commands\Arguments;
use Eastap\PhpBlog\Exceptions\ArgumentsException;

final class ArgumentsTest extends TestCase
{
    public function testItReturnsArgumentsValueByName(): void
    {
        //подготовка
        $arguments = new Arguments(['some_key' => 'some_value']);
        //действие
        $result = $arguments->get('some_key');
        //проверка
        $this->assertEquals($result, 'some_value');
    }

    public function testItReturnsValueAsString(): void
    {
        $arguments = new Arguments(['some_key' => '123']);
        $value = $arguments->get('some_key');
        $this->assertSame($value, '123');
    }

    public function testItThrowsExceptionArgumentIsAbsent(): void
    {
        $arguments = new Arguments([]);
        $this->expectException(ArgumentsException::class);
        $this->expectExceptionMessage('No such argument: some_key');
        $arguments->get('some_key');
    }

    public static function argumentProvider(): iterable
    {
        return [
            ['some_string', 'some_string'], // Тестовый набор
            [' some_string', 'some_string'], // Тестовый набор №2
            [' some_string ', 'some_string'],
            [123, '123'],
            [12.3, '12.3'],
        ];
    }

    /**
     * @dataProvider argumentProvider
     */
    public function testItConvertsArgumentsToString(
        $inputValue,
        $expectedValue
    ): void{
        $arguments = new Arguments(['some_key' => $inputValue]);
        $value = $arguments->get('some_key');
        $this->assertEquals($expectedValue, $value);
    }
}
