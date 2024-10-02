<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\BrightnessClass;
use PHPUnit\Framework\Attributes\DataProvider;

class BrightnessTest extends TestCase
{
    #[DataProvider('standardBrightnessProvider')]
    public function testStandardBrightness(string $input, string $expected): void
    {
        $brightnessClass = BrightnessClass::parse($input);
        $this->assertInstanceOf(BrightnessClass::class, $brightnessClass);
        $this->assertSame($expected, $brightnessClass->toCss());
    }

    public static function standardBrightnessProvider(): array
    {
        return [
            ['brightness-0', '.brightness-0{--tw-brightness:brightness(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-50', '.brightness-50{--tw-brightness:brightness(.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-75', '.brightness-75{--tw-brightness:brightness(.75);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-90', '.brightness-90{--tw-brightness:brightness(.9);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-95', '.brightness-95{--tw-brightness:brightness(.95);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-100', '.brightness-100{--tw-brightness:brightness(1);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-105', '.brightness-105{--tw-brightness:brightness(1.05);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-110', '.brightness-110{--tw-brightness:brightness(1.1);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-125', '.brightness-125{--tw-brightness:brightness(1.25);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-150', '.brightness-150{--tw-brightness:brightness(1.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-200', '.brightness-200{--tw-brightness:brightness(2);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('arbitraryBrightnessProvider')]
    public function testArbitraryBrightness(string $input, string $expected): void
    {
        $brightnessClass = BrightnessClass::parse($input);
        $this->assertInstanceOf(BrightnessClass::class, $brightnessClass);
        $this->assertSame($expected, $brightnessClass->toCss());
    }

    public static function arbitraryBrightnessProvider(): array
    {
        return [
            ['brightness-[0.25]', '.brightness-\[0\.25\]{--tw-brightness:brightness(0.25);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-[1.75]', '.brightness-\[1\.75\]{--tw-brightness:brightness(1.75);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-[80%]', '.brightness-\[80\%\]{--tw-brightness:brightness(80%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['brightness-[2.5]', '.brightness-\[2\.5\]{--tw-brightness:brightness(2.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $brightnessClass = BrightnessClass::parse($input);
        $this->assertNull($brightnessClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['brightness-'],
            ['brightness-25'],
            ['brightness-300'],
            ['brightness-medium'],
            ['not-a-brightness-class'],
            // ['brightness-[invalid]'],
            ['brightness-[2'],
            ['brightness-2.5'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the smallest predefined brightness
        $smallestBrightness = BrightnessClass::parse('brightness-0');
        $this->assertInstanceOf(BrightnessClass::class, $smallestBrightness);
        $this->assertSame('.brightness-0{--tw-brightness:brightness(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $smallestBrightness->toCss());

        // Test the largest predefined brightness
        $largestBrightness = BrightnessClass::parse('brightness-200');
        $this->assertInstanceOf(BrightnessClass::class, $largestBrightness);
        $this->assertSame('.brightness-200{--tw-brightness:brightness(2);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $largestBrightness->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = BrightnessClass::parse('brightness-[1.33]');
        $this->assertInstanceOf(BrightnessClass::class, $decimalArbitrary);
        $this->assertSame('.brightness-\[1\.33\]{--tw-brightness:brightness(1.33);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $decimalArbitrary->toCss());

        // Test an arbitrary value with a different unit
        $differentUnitArbitrary = BrightnessClass::parse('brightness-[120%]');
        $this->assertInstanceOf(BrightnessClass::class, $differentUnitArbitrary);
        $this->assertSame('.brightness-\[120\%\]{--tw-brightness:brightness(120%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $differentUnitArbitrary->toCss());
    }
}