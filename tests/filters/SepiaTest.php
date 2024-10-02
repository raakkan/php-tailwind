<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\SepiaClass;
use PHPUnit\Framework\Attributes\DataProvider;

class SepiaTest extends TestCase
{
    #[DataProvider('standardSepiaProvider')]
    public function testStandardSepia(string $input, string $expected): void
    {
        $sepiaClass = SepiaClass::parse($input);
        $this->assertInstanceOf(SepiaClass::class, $sepiaClass);
        $this->assertSame($expected, $sepiaClass->toCss());
    }

    public static function standardSepiaProvider(): array
    {
        return [
            ['sepia-0', '.sepia-0{--tw-sepia:sepia(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['sepia', '.sepia{--tw-sepia:sepia(100%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('arbitrarySepiaProvider')]
    public function testArbitrarySepia(string $input, string $expected): void
    {
        $sepiaClass = SepiaClass::parse($input);
        $this->assertInstanceOf(SepiaClass::class, $sepiaClass);
        $this->assertSame($expected, $sepiaClass->toCss());
    }

    public static function arbitrarySepiaProvider(): array
    {
        return [
            ['sepia-[0.25]', '.sepia-\[0\.25\]{--tw-sepia:sepia(0.25);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['sepia-[.75]', '.sepia-\[\.75\]{--tw-sepia:sepia(.75);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['sepia-[50%]', '.sepia-\[50\%\]{--tw-sepia:sepia(50%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['sepia-[1.5]', '.sepia-\[1\.5\]{--tw-sepia:sepia(1.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $sepiaClass = SepiaClass::parse($input);
        $this->assertNull($sepiaClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['sepia-'],
            ['sepia-50'],
            ['sepia-100'],
            ['sepia-full'],
            ['not-a-sepia-class'],
            ['sepia-[2'],
            ['sepia-2.5'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the smallest predefined sepia
        $smallestSepia = SepiaClass::parse('sepia-0');
        $this->assertInstanceOf(SepiaClass::class, $smallestSepia);
        $this->assertSame('.sepia-0{--tw-sepia:sepia(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $smallestSepia->toCss());

        // Test the largest predefined sepia
        $largestSepia = SepiaClass::parse('sepia');
        $this->assertInstanceOf(SepiaClass::class, $largestSepia);
        $this->assertSame('.sepia{--tw-sepia:sepia(100%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $largestSepia->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = SepiaClass::parse('sepia-[0.33]');
        $this->assertInstanceOf(SepiaClass::class, $decimalArbitrary);
        $this->assertSame('.sepia-\[0\.33\]{--tw-sepia:sepia(0.33);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $decimalArbitrary->toCss());

        // Test an arbitrary value with a different unit
        $differentUnitArbitrary = SepiaClass::parse('sepia-[75%]');
        $this->assertInstanceOf(SepiaClass::class, $differentUnitArbitrary);
        $this->assertSame('.sepia-\[75\%\]{--tw-sepia:sepia(75%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $differentUnitArbitrary->toCss());
    }
}