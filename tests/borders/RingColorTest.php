<?php

namespace Raakkan\PhpTailwind\Tests\Borders;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\RingColorClass;
use PHPUnit\Framework\Attributes\DataProvider;

class RingColorTest extends TestCase
{
    #[DataProvider('standardRingColorProvider')]
    public function testStandardRingColors(string $input, string $expected): void
    {
        $ringColorClass = RingColorClass::parse($input);
        $this->assertInstanceOf(RingColorClass::class, $ringColorClass);
        $this->assertSame($expected, $ringColorClass->toCss());
    }

    public static function standardRingColorProvider(): array
    {
        return [
            ['ring-red-500', ".ring-red-500{--tw-ring-opacity:1;--tw-ring-color:rgb(239 68 68 / var(--tw-ring-opacity));}"],
            ['ring-blue-300', ".ring-blue-300{--tw-ring-opacity:1;--tw-ring-color:rgb(147 197 253 / var(--tw-ring-opacity));}"],
            ['ring-green-700', ".ring-green-700{--tw-ring-opacity:1;--tw-ring-color:rgb(21 128 61 / var(--tw-ring-opacity));}"],
            ['ring-indigo-500', ".ring-indigo-500{--tw-ring-opacity:1;--tw-ring-color:rgb(99 102 241 / var(--tw-ring-opacity));}"],
            ['ring-black', ".ring-black{--tw-ring-opacity:1;--tw-ring-color:rgb(0 0 0 / var(--tw-ring-opacity));}"],
            ['ring-white', ".ring-white{--tw-ring-opacity:1;--tw-ring-color:rgb(255 255 255 / var(--tw-ring-opacity));}"],
        ];
    }

    #[DataProvider('opacityProvider')]
    public function testOpacity(string $input, string $expected): void
    {
        $ringColorClass = RingColorClass::parse($input);
        $this->assertInstanceOf(RingColorClass::class, $ringColorClass);
        $this->assertSame($expected, $ringColorClass->toCss());
    }

    public static function opacityProvider(): array
    {
        return [
            ['ring-red-500/50', ".ring-red-500\/50{--tw-ring-color:rgb(239 68 68 / 0.5);}"],
            ['ring-blue-300/75', ".ring-blue-300\/75{--tw-ring-color:rgb(147 197 253 / 0.75);}"],
            ['ring-green-700/25', ".ring-green-700\/25{--tw-ring-color:rgb(21 128 61 / 0.25);}"],
            ['ring-indigo-500/100', ".ring-indigo-500\/100{--tw-ring-color:rgb(99 102 241 / 1);}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function testArbitraryValues(string $input, string $expected): void
    {
        $ringColorClass = RingColorClass::parse($input);
        $this->assertInstanceOf(RingColorClass::class, $ringColorClass);
        $this->assertSame($expected, $ringColorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['ring-[#1da1f2]', ".ring-\\[\\#1da1f2\\]{--tw-ring-opacity:1;--tw-ring-color:rgb(29 161 242 / var(--tw-ring-opacity));}"],
            ['ring-[rgb(255,0,0)]', ".ring-\\[rgb\\(255\\2c 0\\2c 0\\)\\]{--tw-ring-opacity:1;--tw-ring-color:rgb(255 0 0 / var(--tw-ring-opacity));}"],
            ['ring-[hsl(200,100%,50%)]', ".ring-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\]{--tw-ring-opacity:1;--tw-ring-color:hsl(200,100%,50%) / var(--tw-ring-opacity);}"],
            // ['ring-[#0000ff]/75', ".ring-\\[\\#0000ff\\]\/75{--tw-ring-color:rgb(0 0 255 / 0.75);}"],
        ];
    }

    #[DataProvider('specialColorProvider')]
    public function testSpecialColors(string $input, string $expected): void
    {
        $ringColorClass = RingColorClass::parse($input);
        $this->assertInstanceOf(RingColorClass::class, $ringColorClass);
        $this->assertSame($expected, $ringColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['ring-inherit', ".ring-inherit{--tw-ring-color:inherit;}"],
            ['ring-current', ".ring-current{--tw-ring-color:currentColor;}"],
            ['ring-transparent', ".ring-transparent{--tw-ring-color:transparent;}"],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $ringColorClass = RingColorClass::parse($input);
        $this->assertNull($ringColorClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['ring-invalid-color'],
            ['ring-blue-1000'],
            ['ring-red-500/invalid'],
            ['outline-red-500'], // Should not parse outline classes
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function testEdgeCases(string $input, string $expected): void
    {
        $ringColorClass = RingColorClass::parse($input);
        $this->assertInstanceOf(RingColorClass::class, $ringColorClass);
        $this->assertSame($expected, $ringColorClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['ring-[#f00]', ".ring-\\[\\#f00\\]{--tw-ring-opacity:1;--tw-ring-color:rgb(255 0 0 / var(--tw-ring-opacity));}"],
            ['ring-[rgba(255,0,0,0.5)]', ".ring-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\]{--tw-ring-opacity:1;--tw-ring-color:rgba(255,0,0,0.5);}"],
            ['ring-[hsla(0,100%,50%,0.5)]', ".ring-\\[hsla\\(0\\2c 100\\%\\2c 50\\%\\2c 0\\.5\\)\\]{--tw-ring-opacity:1;--tw-ring-color:hsla(0,100%,50%,0.5);}"],
            ['ring-slate-50', ".ring-slate-50{--tw-ring-opacity:1;--tw-ring-color:rgb(248 250 252 / var(--tw-ring-opacity));}"],
            ['ring-rose-950', ".ring-rose-950{--tw-ring-opacity:1;--tw-ring-color:rgb(76 5 25 / var(--tw-ring-opacity));}"],
        ];
    }
}