<?php

namespace Raakkan\PhpTailwind\Tests\Borders;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\OutlineColorClass;

class OutlineColorTest extends TestCase
{
    #[DataProvider('standardOutlineColorProvider')]
    public function test_standard_outline_colors(string $input, string $expected): void
    {
        $outlineColorClass = OutlineColorClass::parse($input);
        $this->assertInstanceOf(OutlineColorClass::class, $outlineColorClass);
        $this->assertSame($expected, $outlineColorClass->toCss());
    }

    public static function standardOutlineColorProvider(): array
    {
        return [
            ['outline-red-500', '.outline-red-500{outline-color:#ef4444;}'],
            ['outline-blue-300', '.outline-blue-300{outline-color:#93c5fd;}'],
            ['outline-green-700', '.outline-green-700{outline-color:#15803d;}'],
            ['outline-indigo-500', '.outline-indigo-500{outline-color:#6366f1;}'],
            ['outline-transparent', '.outline-transparent{outline-color:transparent;}'],
            ['outline-current', '.outline-current{outline-color:currentColor;}'],
            ['outline-black', '.outline-black{outline-color:#000000;}'],
            ['outline-white', '.outline-white{outline-color:#ffffff;}'],
        ];
    }

    #[DataProvider('opacityProvider')]
    public function test_opacity(string $input, string $expected): void
    {
        $outlineColorClass = OutlineColorClass::parse($input);
        $this->assertInstanceOf(OutlineColorClass::class, $outlineColorClass);
        $this->assertSame($expected, $outlineColorClass->toCss());
    }

    public static function opacityProvider(): array
    {
        return [
            ['outline-red-500/50', ".outline-red-500\/50{outline-color:rgb(239 68 68 / 0.5);}"],
            ['outline-blue-300/75', ".outline-blue-300\/75{outline-color:rgb(147 197 253 / 0.75);}"],
            ['outline-green-700/25', ".outline-green-700\/25{outline-color:rgb(21 128 61 / 0.25);}"],
            ['outline-indigo-500/100', ".outline-indigo-500\/100{outline-color:rgb(99 102 241 / 1);}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function test_arbitrary_values(string $input, string $expected): void
    {
        $outlineColorClass = OutlineColorClass::parse($input);
        $this->assertInstanceOf(OutlineColorClass::class, $outlineColorClass);
        $this->assertSame($expected, $outlineColorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['outline-[#1da1f2]', '.outline-\\[\\#1da1f2\\]{outline-color:#1da1f2;}'],
            ['outline-[rgb(255,0,0)]', '.outline-\\[rgb\\(255\\2c 0\\2c 0\\)\\]{outline-color:rgb(255 0 0);}'],
            ['outline-[hsl(200,100%,50%)]', '.outline-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\]{outline-color:hsl(200,100%,50%);}'],
            // ['outline-[#0000ff]/75', ".outline-\\[\\#0000ff\\]\/75{outline-color:#0000ff;}"],
        ];
    }

    #[DataProvider('specialColorProvider')]
    public function test_special_colors(string $input, string $expected): void
    {
        $outlineColorClass = OutlineColorClass::parse($input);
        $this->assertInstanceOf(OutlineColorClass::class, $outlineColorClass);
        $this->assertSame($expected, $outlineColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['outline-inherit', '.outline-inherit{outline-color:inherit;}'],
            ['outline-current', '.outline-current{outline-color:currentColor;}'],
            ['outline-transparent', '.outline-transparent{outline-color:transparent;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function test_invalid_inputs(string $input): void
    {
        $outlineColorClass = OutlineColorClass::parse($input);
        $this->assertNull($outlineColorClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['outline-invalid-color'],
            // ['outline-red'],
            ['outline-blue-1000'],
            // ['outline-[invalid]'],
            ['outline-red-500/invalid'],
            ['border-red-500'], // Should not parse border classes
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function test_edge_cases(string $input, string $expected): void
    {
        $outlineColorClass = OutlineColorClass::parse($input);
        $this->assertInstanceOf(OutlineColorClass::class, $outlineColorClass);
        $this->assertSame($expected, $outlineColorClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['outline-[#f00]', '.outline-\\[\\#f00\\]{outline-color:#f00;}'],
            ['outline-[rgba(255,0,0,0.5)]', '.outline-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\]{outline-color:rgba(255,0,0,0.5);}'],
            ['outline-[hsla(0,100%,50%,0.5)]', '.outline-\\[hsla\\(0\\2c 100\\%\\2c 50\\%\\2c 0\\.5\\)\\]{outline-color:hsla(0,100%,50%,0.5);}'],
            ['outline-slate-50', '.outline-slate-50{outline-color:#f8fafc;}'],
            ['outline-rose-950', '.outline-rose-950{outline-color:#4c0519;}'],
        ];
    }
}
