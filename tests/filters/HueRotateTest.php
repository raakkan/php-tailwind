<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\HueRotateClass;

class HueRotateTest extends TestCase
{
    #[DataProvider('standardHueRotateProvider')]
    public function testStandardHueRotate(string $input, string $expected): void
    {
        $hueRotateClass = HueRotateClass::parse($input);
        $this->assertInstanceOf(HueRotateClass::class, $hueRotateClass);
        $this->assertSame($expected, $hueRotateClass->toCss());
    }

    public static function standardHueRotateProvider(): array
    {
        return [
            ['hue-rotate-0', '.hue-rotate-0{--tw-hue-rotate:hue-rotate(0deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['hue-rotate-15', '.hue-rotate-15{--tw-hue-rotate:hue-rotate(15deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['hue-rotate-30', '.hue-rotate-30{--tw-hue-rotate:hue-rotate(30deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['hue-rotate-60', '.hue-rotate-60{--tw-hue-rotate:hue-rotate(60deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['hue-rotate-90', '.hue-rotate-90{--tw-hue-rotate:hue-rotate(90deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['hue-rotate-180', '.hue-rotate-180{--tw-hue-rotate:hue-rotate(180deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('negativeHueRotateProvider')]
    public function testNegativeHueRotate(string $input, string $expected): void
    {
        $hueRotateClass = HueRotateClass::parse($input);
        $this->assertInstanceOf(HueRotateClass::class, $hueRotateClass);
        $this->assertSame($expected, $hueRotateClass->toCss());
    }

    public static function negativeHueRotateProvider(): array
    {
        return [
            ['-hue-rotate-15', '.hue-rotate--15{--tw-hue-rotate:hue-rotate(-15deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['-hue-rotate-30', '.hue-rotate--30{--tw-hue-rotate:hue-rotate(-30deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['-hue-rotate-60', '.hue-rotate--60{--tw-hue-rotate:hue-rotate(-60deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['-hue-rotate-90', '.hue-rotate--90{--tw-hue-rotate:hue-rotate(-90deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['-hue-rotate-180', '.hue-rotate--180{--tw-hue-rotate:hue-rotate(-180deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('arbitraryHueRotateProvider')]
    public function testArbitraryHueRotate(string $input, string $expected): void
    {
        $hueRotateClass = HueRotateClass::parse($input);
        $this->assertInstanceOf(HueRotateClass::class, $hueRotateClass);
        $this->assertSame($expected, $hueRotateClass->toCss());
    }

    public static function arbitraryHueRotateProvider(): array
    {
        return [
            ['hue-rotate-[23deg]', '.hue-rotate-\[23deg\]{--tw-hue-rotate:hue-rotate(23deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['hue-rotate-[2.3rad]', '.hue-rotate-\[2\.3rad\]{--tw-hue-rotate:hue-rotate(2.3rad);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['hue-rotate-[0.5turn]', '.hue-rotate-\[0\.5turn\]{--tw-hue-rotate:hue-rotate(0.5turn);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['-hue-rotate-[120deg]', '.hue-rotate-\[-120deg\]{--tw-hue-rotate:hue-rotate(-120deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $hueRotateClass = HueRotateClass::parse($input);
        $this->assertNull($hueRotateClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            // ['hue-rotate'],
            ['hue-rotate-'],
            ['hue-rotate-1'],
            ['hue-rotate-45'],
            ['hue-rotate-full'],
            ['not-a-hue-rotate-class'],
            ['hue-rotate-['],
            ['hue-rotate-50deg'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the default hue-rotate (0deg)
        $defaultHueRotate = HueRotateClass::parse('hue-rotate-0');
        $this->assertInstanceOf(HueRotateClass::class, $defaultHueRotate);
        $this->assertSame('.hue-rotate-0{--tw-hue-rotate:hue-rotate(0deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $defaultHueRotate->toCss());

        // Test maximum standard value (180deg)
        $maxStandardHueRotate = HueRotateClass::parse('hue-rotate-180');
        $this->assertInstanceOf(HueRotateClass::class, $maxStandardHueRotate);
        $this->assertSame('.hue-rotate-180{--tw-hue-rotate:hue-rotate(180deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $maxStandardHueRotate->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = HueRotateClass::parse('hue-rotate-[12.5deg]');
        $this->assertInstanceOf(HueRotateClass::class, $decimalArbitrary);
        $this->assertSame('.hue-rotate-\[12\.5deg\]{--tw-hue-rotate:hue-rotate(12.5deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $decimalArbitrary->toCss());

        // Test an arbitrary value with negative value
        $negativeArbitrary = HueRotateClass::parse('-hue-rotate-[45deg]');
        $this->assertInstanceOf(HueRotateClass::class, $negativeArbitrary);
        $this->assertSame('.hue-rotate-\[-45deg\]{--tw-hue-rotate:hue-rotate(-45deg);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $negativeArbitrary->toCss());
    }
}
