<?php

namespace Raakkan\PhpTailwind\Tests\Borders;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\BorderColorClass;

class BorderColorTest extends TestCase
{
    #[DataProvider('standardBorderColorProvider')]
    public function test_standard_border_colors(string $input, string $expected): void
    {
        $borderColorClass = BorderColorClass::parse($input);
        $this->assertInstanceOf(BorderColorClass::class, $borderColorClass);
        $this->assertSame($expected, $borderColorClass->toCss());
    }

    public static function standardBorderColorProvider(): array
    {
        return [
            ['border-red-500', '.border-red-500{--tw-border-opacity:1;border-color:rgb(239 68 68 / var(--tw-border-opacity));}'],
            ['border-blue-300', '.border-blue-300{--tw-border-opacity:1;border-color:rgb(147 197 253 / var(--tw-border-opacity));}'],
            ['border-green-700', '.border-green-700{--tw-border-opacity:1;border-color:rgb(21 128 61 / var(--tw-border-opacity));}'],
            ['border-indigo-500', '.border-indigo-500{--tw-border-opacity:1;border-color:rgb(99 102 241 / var(--tw-border-opacity));}'],
            ['border-transparent', '.border-transparent{border-color:transparent;}'],
            ['border-current', '.border-current{border-color:currentColor;}'],
            ['border-black', '.border-black{--tw-border-opacity:1;border-color:rgb(0 0 0 / var(--tw-border-opacity));}'],
            ['border-white', '.border-white{--tw-border-opacity:1;border-color:rgb(255 255 255 / var(--tw-border-opacity));}'],
        ];
    }

    #[DataProvider('borderSidesProvider')]
    public function test_border_sides(string $input, string $expected): void
    {
        $borderColorClass = BorderColorClass::parse($input);
        $this->assertInstanceOf(BorderColorClass::class, $borderColorClass);
        $this->assertSame($expected, $borderColorClass->toCss());
    }

    public static function borderSidesProvider(): array
    {
        return [
            ['border-t-red-500', '.border-t-red-500{--tw-border-opacity:1;border-top-color:rgb(239 68 68 / var(--tw-border-opacity));}'],
            ['border-r-blue-300', '.border-r-blue-300{--tw-border-opacity:1;border-right-color:rgb(147 197 253 / var(--tw-border-opacity));}'],
            ['border-b-green-700', '.border-b-green-700{--tw-border-opacity:1;border-bottom-color:rgb(21 128 61 / var(--tw-border-opacity));}'],
            ['border-l-indigo-500', '.border-l-indigo-500{--tw-border-opacity:1;border-left-color:rgb(99 102 241 / var(--tw-border-opacity));}'],
            ['border-x-purple-400', '.border-x-purple-400{--tw-border-opacity:1;border-left-color:rgb(192 132 252 / var(--tw-border-opacity));border-right-color:rgb(192 132 252 / var(--tw-border-opacity));}'],
            ['border-y-yellow-200', '.border-y-yellow-200{--tw-border-opacity:1;border-top-color:rgb(254 240 138 / var(--tw-border-opacity));border-bottom-color:rgb(254 240 138 / var(--tw-border-opacity));}'],
        ];
    }

    #[DataProvider('opacityProvider')]
    public function test_opacity(string $input, string $expected): void
    {
        $borderColorClass = BorderColorClass::parse($input);
        $this->assertInstanceOf(BorderColorClass::class, $borderColorClass);
        $this->assertSame($expected, $borderColorClass->toCss());
    }

    public static function opacityProvider(): array
    {
        return [
            ['border-red-500/50', ".border-red-500\/50{border-color:rgb(239 68 68 / 0.5);}"],
            ['border-blue-300/75', ".border-blue-300\/75{border-color:rgb(147 197 253 / 0.75);}"],
            ['border-t-green-700/25', ".border-t-green-700\/25{border-top-color:rgb(21 128 61 / 0.25);}"],
            ['border-r-indigo-500/100', ".border-r-indigo-500\/100{border-right-color:rgb(99 102 241 / 1);}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function test_arbitrary_values(string $input, string $expected): void
    {
        $borderColorClass = BorderColorClass::parse($input);
        $this->assertInstanceOf(BorderColorClass::class, $borderColorClass);
        $this->assertSame($expected, $borderColorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['border-[#1da1f2]', '.border-\\[\\#1da1f2\\]{--tw-border-opacity:1;border-color:rgb(29 161 242 / var(--tw-border-opacity));}'],
            ['border-t-[rgb(255,0,0)]', '.border-t-\\[rgb\\(255\\2c 0\\2c 0\\)\\]{--tw-border-opacity:1;border-top-color:rgb(255 0 0 / var(--tw-border-opacity));}'],
            ['border-r-[hsl(200,100%,50%)]', '.border-r-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\]{--tw-border-opacity:1;border-right-color:hsl(200 100% 50% / var(--tw-border-opacity));}'],
            // ['border-[#0000ff]/75', ".border-\\[\\#0000ff\\]\/75{border-color:rgb(0 0 255 / 0.75);}"],
        ];
    }

    #[DataProvider('specialColorProvider')]
    public function test_special_colors(string $input, string $expected): void
    {
        $borderColorClass = BorderColorClass::parse($input);
        $this->assertInstanceOf(BorderColorClass::class, $borderColorClass);
        $this->assertSame($expected, $borderColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['border-inherit', '.border-inherit{border-color:inherit;}'],
            ['border-current', '.border-current{border-color:currentColor;}'],
            ['border-transparent', '.border-transparent{border-color:transparent;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function test_invalid_inputs(string $input): void
    {
        $borderColorClass = BorderColorClass::parse($input);
        $this->assertNull($borderColorClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['border-invalid-color'],
            // ['border-red'],
            ['border-blue-1000'],
            // ['border-[invalid]'],
            ['border-red-500/invalid'],
        ];
    }
}
