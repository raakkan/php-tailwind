<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\InvertClass;
use PHPUnit\Framework\Attributes\DataProvider;

class InvertTest extends TestCase
{
    #[DataProvider('standardInvertProvider')]
    public function testStandardInvert(string $input, string $expected): void
    {
        $invertClass = InvertClass::parse($input);
        $this->assertInstanceOf(InvertClass::class, $invertClass);
        $this->assertSame($expected, $invertClass->toCss());
    }

    public static function standardInvertProvider(): array
    {
        return [
            ['invert-0', '.invert-0{--tw-invert:invert(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['invert-100', '.invert-100{--tw-invert:invert(100%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('arbitraryInvertProvider')]
    public function testArbitraryInvert(string $input, string $expected): void
    {
        $invertClass = InvertClass::parse($input);
        $this->assertInstanceOf(InvertClass::class, $invertClass);
        $this->assertSame($expected, $invertClass->toCss());
    }

    public static function arbitraryInvertProvider(): array
    {
        return [
            ['invert-[0.25]', '.invert-\[0\.25\]{--tw-invert:invert(0.25);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['invert-[.75]', '.invert-\[\.75\]{--tw-invert:invert(.75);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['invert-[50%]', '.invert-\[50\%\]{--tw-invert:invert(50%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['invert-[1.5]', '.invert-\[1\.5\]{--tw-invert:invert(1.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $invertClass = InvertClass::parse($input);
        $this->assertNull($invertClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['invert-'],
            ['invert-50'],
            ['invert-200'],
            ['invert-full'],
            ['not-an-invert-class'],
            ['invert-[2'],
            ['invert-2.5'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the smallest predefined invert
        $smallestInvert = InvertClass::parse('invert-0');
        $this->assertInstanceOf(InvertClass::class, $smallestInvert);
        $this->assertSame('.invert-0{--tw-invert:invert(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $smallestInvert->toCss());

        // Test the largest predefined invert
        $largestInvert = InvertClass::parse('invert-100');
        $this->assertInstanceOf(InvertClass::class, $largestInvert);
        $this->assertSame('.invert-100{--tw-invert:invert(100%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $largestInvert->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = InvertClass::parse('invert-[0.33]');
        $this->assertInstanceOf(InvertClass::class, $decimalArbitrary);
        $this->assertSame('.invert-\[0\.33\]{--tw-invert:invert(0.33);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $decimalArbitrary->toCss());

        // Test an arbitrary value with a different unit
        $differentUnitArbitrary = InvertClass::parse('invert-[75%]');
        $this->assertInstanceOf(InvertClass::class, $differentUnitArbitrary);
        $this->assertSame('.invert-\[75\%\]{--tw-invert:invert(75%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $differentUnitArbitrary->toCss());
    }
}