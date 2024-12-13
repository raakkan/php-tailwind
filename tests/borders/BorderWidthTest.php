<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\BorderWidthClass;

class BorderWidthTest extends TestCase
{
    #[DataProvider('borderWidthClassProvider')]
    public function test_border_width_class(string $input, string $expected): void
    {
        $borderWidthClass = BorderWidthClass::parse($input);
        $this->assertInstanceOf(BorderWidthClass::class, $borderWidthClass);
        $this->assertSame($expected, $borderWidthClass->toCss());
    }

    public static function borderWidthClassProvider(): array
    {
        return [
            // All sides
            ['border', '.border{border-width:1px;}'],
            ['border-0', '.border-0{border-width:0px;}'],
            ['border-2', '.border-2{border-width:2px;}'],
            ['border-4', '.border-4{border-width:4px;}'],
            ['border-8', '.border-8{border-width:8px;}'],

            // Individual sides
            ['border-t', '.border-t{border-top-width:1px;}'],
            ['border-r', '.border-r{border-right-width:1px;}'],
            ['border-b', '.border-b{border-bottom-width:1px;}'],
            ['border-l', '.border-l{border-left-width:1px;}'],
            ['border-x', '.border-x{border-left-width:1px;border-right-width:1px;}'],
            ['border-y', '.border-y{border-top-width:1px;border-bottom-width:1px;}'],
            ['border-t-0', '.border-t-0{border-top-width:0px;}'],
            ['border-r-2', '.border-r-2{border-right-width:2px;}'],
            ['border-b-4', '.border-b-4{border-bottom-width:4px;}'],
            ['border-l-8', '.border-l-8{border-left-width:8px;}'],

            // Horizontal and vertical
            ['border-x-0', '.border-x-0{border-left-width:0px;border-right-width:0px;}'],
            ['border-y-2', '.border-y-2{border-top-width:2px;border-bottom-width:2px;}'],

            // Logical properties
            ['border-s-4', '.border-s-4{border-inline-start-width:4px;}'],
            ['border-e-8', '.border-e-8{border-inline-end-width:8px;}'],
        ];
    }

    #[DataProvider('arbitraryBorderWidthClassProvider')]
    public function test_arbitrary_border_width_class(string $input, string $expected): void
    {
        $borderWidthClass = BorderWidthClass::parse($input);
        $this->assertInstanceOf(BorderWidthClass::class, $borderWidthClass);
        $this->assertSame($expected, $borderWidthClass->toCss());
    }

    public static function arbitraryBorderWidthClassProvider(): array
    {
        return [
            ['border-[3px]', '.border-\\[3px\\]{border-width:3px;}'],
            ['border-[0.5em]', '.border-\\[0\\.5em\\]{border-width:0.5em;}'],
            ['border-t-[10px]', '.border-t-\\[10px\\]{border-top-width:10px;}'],
            ['border-r-[2rem]', '.border-r-\\[2rem\\]{border-right-width:2rem;}'],
            ['border-b-[5%]', '.border-b-\\[5\\%\\]{border-bottom-width:5%;}'],
            ['border-l-[calc(1px+2px)]', '.border-l-\\[calc\\(1px\\+2px\\)\\]{border-left-width:calc(1px+2px);}'],
            // ['border-x-[var(--border-width)]', ".border-x-\\[var\\(--border-width\\)\\]{border-left-width:var(--border-width);border-right-width:var(--border-width);}"],
        ];
    }

    public function test_invalid_border_width_class(): void
    {
        $this->assertNull(BorderWidthClass::parse('invalid-class'));
    }

    #[DataProvider('invalidBorderWidthValueProvider')]
    public function test_border_width_class_with_invalid_value(string $input): void
    {
        $borderWidthClass = BorderWidthClass::parse($input);
        $this->assertInstanceOf(BorderWidthClass::class, $borderWidthClass);
        $this->assertSame('', $borderWidthClass->toCss());
    }

    public static function invalidBorderWidthValueProvider(): array
    {
        return [
            ['border-1'],
            ['border-3'],
            ['border-5'],
            ['border-t-7'],
            ['border-r-9'],
            ['border-b-10'],
            // ['border-l-DEFAULT'],
        ];
    }

    #[DataProvider('invalidArbitraryBorderWidthClassProvider')]
    public function test_invalid_arbitrary_border_width_class(string $input): void
    {
        $borderWidthClass = BorderWidthClass::parse($input);
        $this->assertInstanceOf(BorderWidthClass::class, $borderWidthClass);
        $this->assertSame('', $borderWidthClass->toCss());
    }

    public static function invalidArbitraryBorderWidthClassProvider(): array
    {
        return [
            ['border-[invalid]'],
            ['border-[10]'],
            ['border-[em]'],
            ['border-t-[]'],
            ['border-r-[10px'],
            ['border-b-10px]'],
        ];
    }
}
