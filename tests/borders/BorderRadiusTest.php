<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\BorderRadiusClass;

class BorderRadiusTest extends TestCase
{
    #[DataProvider('borderRadiusClassProvider')]
    public function test_border_radius_class(string $input, string $expected): void
    {
        $borderRadiusClass = BorderRadiusClass::parse($input);
        $this->assertInstanceOf(BorderRadiusClass::class, $borderRadiusClass);
        $this->assertSame($expected, $borderRadiusClass->toCss());
    }

    public static function borderRadiusClassProvider(): array
    {
        return [
            // warnings for rounded need to check
            ['rounded', '.rounded{border-radius:0.25rem;}'],
            ['rounded-t', '.rounded-t{border-top-left-radius:0.25rem;border-top-right-radius:0.25rem;}'],
            ['rounded-r', '.rounded-r{border-top-right-radius:0.25rem;border-bottom-right-radius:0.25rem;}'],
            ['rounded-t-none', '.rounded-t-none{border-top-left-radius:0px;border-top-right-radius:0px;}'],
            ['rounded-none', '.rounded-none{border-radius:0px;}'],
            ['rounded-sm', '.rounded-sm{border-radius:0.125rem;}'],
            ['rounded-md', '.rounded-md{border-radius:0.375rem;}'],
            ['rounded-lg', '.rounded-lg{border-radius:0.5rem;}'],
            ['rounded-xl', '.rounded-xl{border-radius:0.75rem;}'],
            ['rounded-2xl', '.rounded-2xl{border-radius:1rem;}'],
            ['rounded-3xl', '.rounded-3xl{border-radius:1.5rem;}'],
            ['rounded-full', '.rounded-full{border-radius:9999px;}'],
            ['rounded-t-lg', '.rounded-t-lg{border-top-left-radius:0.5rem;border-top-right-radius:0.5rem;}'],
            ['rounded-r-lg', '.rounded-r-lg{border-top-right-radius:0.5rem;border-bottom-right-radius:0.5rem;}'],
            ['rounded-b-lg', '.rounded-b-lg{border-bottom-right-radius:0.5rem;border-bottom-left-radius:0.5rem;}'],
            ['rounded-l-lg', '.rounded-l-lg{border-top-left-radius:0.5rem;border-bottom-left-radius:0.5rem;}'],
            ['rounded-tl-lg', '.rounded-tl-lg{border-top-left-radius:0.5rem;}'],
            ['rounded-tr-lg', '.rounded-tr-lg{border-top-right-radius:0.5rem;}'],
            ['rounded-br-lg', '.rounded-br-lg{border-bottom-right-radius:0.5rem;}'],
            ['rounded-bl-lg', '.rounded-bl-lg{border-bottom-left-radius:0.5rem;}'],
            ['rounded-s-lg', '.rounded-s-lg{border-start-start-radius:0.5rem;border-end-start-radius:0.5rem;}'],
            ['rounded-e-lg', '.rounded-e-lg{border-start-end-radius:0.5rem;border-end-end-radius:0.5rem;}'],
            ['rounded-ss-lg', '.rounded-ss-lg{border-start-start-radius:0.5rem;}'],
            ['rounded-se-lg', '.rounded-se-lg{border-start-end-radius:0.5rem;}'],
            ['rounded-ee-lg', '.rounded-ee-lg{border-end-end-radius:0.5rem;}'],
            ['rounded-es-lg', '.rounded-es-lg{border-end-start-radius:0.5rem;}'],
        ];
    }

    #[DataProvider('arbitraryBorderRadiusClassProvider')]
    public function test_arbitrary_border_radius_class(string $input, string $expected): void
    {
        $borderRadiusClass = BorderRadiusClass::parse($input);
        $this->assertInstanceOf(BorderRadiusClass::class, $borderRadiusClass);
        $this->assertSame($expected, $borderRadiusClass->toCss());
    }

    public static function arbitraryBorderRadiusClassProvider(): array
    {
        return [
            ['rounded-[10px]', '.rounded-\\[10px\\]{border-radius:10px;}'],
            ['rounded-[0.5em]', '.rounded-\\[0\\.5em\\]{border-radius:0.5em;}'],
            ['rounded-t-[20px]', '.rounded-t-\\[20px\\]{border-top-left-radius:20px;border-top-right-radius:20px;}'],
            ['rounded-r-[1.5rem]', '.rounded-r-\\[1\\.5rem\\]{border-top-right-radius:1.5rem;border-bottom-right-radius:1.5rem;}'],
            ['rounded-tl-[25%]', '.rounded-tl-\\[25\\%\\]{border-top-left-radius:25%;}'],
        ];
    }

    public function test_invalid_border_radius_class(): void
    {
        $this->assertNull(BorderRadiusClass::parse('invalid-class'));
    }

    public function test_border_radius_class_with_invalid_value(): void
    {
        $borderRadiusClass = BorderRadiusClass::parse('rounded-invalid');
        $this->assertInstanceOf(BorderRadiusClass::class, $borderRadiusClass);
        $this->assertSame('', $borderRadiusClass->toCss());
    }

    // #[DataProvider('invalidArbitraryBorderRadiusClassProvider')]
    // public function testInvalidArbitraryBorderRadiusClass(string $input): void
    // {
    //     $borderRadiusClass = BorderRadiusClass::parse($input);
    //     $this->assertInstanceOf(BorderRadiusClass::class, $borderRadiusClass);
    //     $this->assertSame('', $borderRadiusClass->toCss());
    // }

    // public static function invalidArbitraryBorderRadiusClassProvider(): array
    // {
    //     return [
    //         ['rounded-[invalid]'],
    //         ['rounded-[10]'],
    //         ['rounded-[em]'],
    //     ];
    // }
}
