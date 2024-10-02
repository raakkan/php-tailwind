<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\BlurClass;
use PHPUnit\Framework\Attributes\DataProvider;

class BlurTest extends TestCase
{
    #[DataProvider('standardBlurProvider')]
    public function testStandardBlurs(string $input, string $expected): void
    {
        $blurClass = BlurClass::parse($input);
        $this->assertInstanceOf(BlurClass::class, $blurClass);
        $this->assertSame($expected, $blurClass->toCss());
    }

    public static function standardBlurProvider(): array
    {
        return [
            ['blur-none', '.blur-none{--tw-blur:blur(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['blur-sm', '.blur-sm{--tw-blur:blur(4px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['blur', '.blur-DEFAULT{--tw-blur:blur(8px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['blur-md', '.blur-md{--tw-blur:blur(12px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['blur-lg', '.blur-lg{--tw-blur:blur(16px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['blur-xl', '.blur-xl{--tw-blur:blur(24px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['blur-2xl', '.blur-2xl{--tw-blur:blur(40px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['blur-3xl', '.blur-3xl{--tw-blur:blur(64px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('arbitraryBlurProvider')]
    public function testArbitraryBlurs(string $input, string $expected): void
    {
        $blurClass = BlurClass::parse($input);
        $this->assertInstanceOf(BlurClass::class, $blurClass);
        $this->assertSame($expected, $blurClass->toCss());
    }

    public static function arbitraryBlurProvider(): array
    {
        return [
            ['blur-[2px]', '.blur-\[2px\]{--tw-blur:blur(2px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['blur-[0.5rem]', '.blur-\[0\.5rem\]{--tw-blur:blur(0.5rem);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['blur-[6px]', '.blur-\[6px\]{--tw-blur:blur(6px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['blur-[20px]', '.blur-\[20px\]{--tw-blur:blur(20px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $blurClass = BlurClass::parse($input);
        $this->assertNull($blurClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['blur-'],
            ['blur-xs'],
            ['blur-4xl'],
            ['blur-medium'],
            ['not-a-blur-class'],
            // ['blur-[invalid]'],
            ['blur-[2rem'],
            ['blur-2px'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the default blur
        $defaultBlur = BlurClass::parse('blur');
        $this->assertInstanceOf(BlurClass::class, $defaultBlur);
        $this->assertSame('.blur-DEFAULT{--tw-blur:blur(8px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $defaultBlur->toCss());

        // Test the smallest predefined blur
        $smallestBlur = BlurClass::parse('blur-none');
        $this->assertInstanceOf(BlurClass::class, $smallestBlur);
        $this->assertSame('.blur-none{--tw-blur:blur(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $smallestBlur->toCss());

        // Test the largest predefined blur
        $largestBlur = BlurClass::parse('blur-3xl');
        $this->assertInstanceOf(BlurClass::class, $largestBlur);
        $this->assertSame('.blur-3xl{--tw-blur:blur(64px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $largestBlur->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = BlurClass::parse('blur-[1.5px]');
        $this->assertInstanceOf(BlurClass::class, $decimalArbitrary);
        $this->assertSame('.blur-\[1\.5px\]{--tw-blur:blur(1.5px);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $decimalArbitrary->toCss());

        // Test an arbitrary value with a different unit
        $differentUnitArbitrary = BlurClass::parse('blur-[10%]');
        $this->assertInstanceOf(BlurClass::class, $differentUnitArbitrary);
        $this->assertSame('.blur-\[10\%\]{--tw-blur:blur(10%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $differentUnitArbitrary->toCss());
    }
}