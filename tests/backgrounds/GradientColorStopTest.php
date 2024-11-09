<?php

namespace Raakkan\PhpTailwind\Tests\Backgrounds;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Backgrounds\GradientColorStopClass;

class GradientColorStopTest extends TestCase
{
    #[DataProvider('standardColorStopProvider')]
    public function testStandardColorStops(string $input, string $expected): void
    {
        $colorStopClass = GradientColorStopClass::parse($input);
        $this->assertInstanceOf(GradientColorStopClass::class, $colorStopClass);
        $this->assertSame($expected, $colorStopClass->toCss());
    }

    public static function standardColorStopProvider(): array
    {
        return [
            ['from-red-500', '.from-red-500{--tw-gradient-from:#ef4444 var(--tw-gradient-from-position);--tw-gradient-to:rgb(239 68 68 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from),var(--tw-gradient-to);}'],
            ['via-blue-300', '.via-blue-300{--tw-gradient-to:rgb(147 197 253 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from),#93c5fd var(--tw-gradient-via-position),var(--tw-gradient-to);}'],
            ['to-green-700', '.to-green-700{--tw-gradient-to:#15803d var(--tw-gradient-to-position);}'],
        ];
    }

    #[DataProvider('arbitraryColorStopProvider')]
    public function testArbitraryColorStops(string $input, string $expected): void
    {
        $colorStopClass = GradientColorStopClass::parse($input);
        $this->assertInstanceOf(GradientColorStopClass::class, $colorStopClass);
        $this->assertSame($expected, $colorStopClass->toCss());
    }

    public static function arbitraryColorStopProvider(): array
    {
        return [
            ['from-[#1da1f2]', '.from-\\[\\#1da1f2\\]{--tw-gradient-from:#1da1f2 var(--tw-gradient-from-position);--tw-gradient-to:rgb(29 161 242 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from),var(--tw-gradient-to);}'],
            // ['via-[rgb(255,0,0)]', ".via-\\[rgb\\(255\\2c 0\\2c 0\\)\\]{--tw-gradient-to:rgb(255 0 0/0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from),rgb(255,0,0) var(--tw-gradient-via-position),var(--tw-gradient-to);}"],
            // ['to-[hsl(200,100%,50%)]', ".to-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\]{--tw-gradient-to:hsl(200,100%,50%) var(--tw-gradient-to-position);}"],
        ];
    }

    #[DataProvider('specialColorStopProvider')]
    public function testSpecialColorStops(string $input, string $expected): void
    {
        $colorStopClass = GradientColorStopClass::parse($input);
        $this->assertInstanceOf(GradientColorStopClass::class, $colorStopClass);
        $this->assertSame($expected, $colorStopClass->toCss());
    }

    public static function specialColorStopProvider(): array
    {
        return [
            ['from-inherit', '.from-inherit{--tw-gradient-from:inherit var(--tw-gradient-from-position);--tw-gradient-to:rgb(255 255 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from),var(--tw-gradient-to);}'],
            ['via-current', '.via-current{--tw-gradient-to:rgb(255 255 255 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from),currentColor var(--tw-gradient-via-position),var(--tw-gradient-to);}'],
            ['to-transparent', '.to-transparent{--tw-gradient-to:transparent var(--tw-gradient-to-position);}'],
            ['from-transparent', '.from-transparent{--tw-gradient-from:transparent var(--tw-gradient-from-position);--tw-gradient-to:rgb(0 0 0 / 0) var(--tw-gradient-to-position);--tw-gradient-stops:var(--tw-gradient-from),var(--tw-gradient-to);}'],
        ];
    }

    // #[DataProvider('invalidColorStopProvider')]
    // public function testInvalidColorStops(string $input): void
    // {
    //     $colorStopClass = GradientColorStopClass::parse($input);
    //     $this->assertNull($colorStopClass);
    // }

    // public static function invalidColorStopProvider(): array
    // {
    //     return [
    //         ['from-invalid'],
    //         ['via-red'],
    //         ['to-blue-1000'],
    //         ['from-[invalid]'],
    //         ['via-red-500/invalid'],
    //     ];
    // }

    // public function testEdgeCases(): void
    // {
    //     // Test with opacity
    //     // $withOpacity = GradientColorStopClass::parse('from-red-500/50');
    //     // $this->assertInstanceOf(GradientColorStopClass::class, $withOpacity);
    //     // $this->assertStringContainsString('--tw-gradient-from: #ef4444', $withOpacity->toCss());

    //     // Test with arbitrary color and opacity
    //     // $arbitraryWithOpacity = GradientColorStopClass::parse('to-[#FF00FF]/75');
    //     // $this->assertInstanceOf(GradientColorStopClass::class, $arbitraryWithOpacity);
    //     // $this->assertStringContainsString('--tw-gradient-to: #FF00FF', $arbitraryWithOpacity->toCss());
    // }
}
