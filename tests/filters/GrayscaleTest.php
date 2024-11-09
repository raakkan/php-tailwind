<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\GrayscaleClass;

class GrayscaleTest extends TestCase
{
    #[DataProvider('standardGrayscaleProvider')]
    public function testStandardGrayscale(string $input, string $expected): void
    {
        $grayscaleClass = GrayscaleClass::parse($input);
        $this->assertInstanceOf(GrayscaleClass::class, $grayscaleClass);
        $this->assertSame($expected, $grayscaleClass->toCss());
    }

    public static function standardGrayscaleProvider(): array
    {
        return [
            ['grayscale', '.grayscale{--tw-grayscale:grayscale(100%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['grayscale-0', '.grayscale-0{--tw-grayscale:grayscale(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('arbitraryGrayscaleProvider')]
    public function testArbitraryGrayscale(string $input, string $expected): void
    {
        $grayscaleClass = GrayscaleClass::parse($input);
        $this->assertInstanceOf(GrayscaleClass::class, $grayscaleClass);
        $this->assertSame($expected, $grayscaleClass->toCss());
    }

    public static function arbitraryGrayscaleProvider(): array
    {
        return [
            ['grayscale-[0.5]', '.grayscale-\[0\.5\]{--tw-grayscale:grayscale(0.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['grayscale-[50%]', '.grayscale-\[50\%\]{--tw-grayscale:grayscale(50%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['grayscale-[.25]', '.grayscale-\[\.25\]{--tw-grayscale:grayscale(.25);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['grayscale-[75%]', '.grayscale-\[75\%\]{--tw-grayscale:grayscale(75%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $grayscaleClass = GrayscaleClass::parse($input);
        $this->assertNull($grayscaleClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['grayscale-'],
            ['grayscale-1'],
            ['grayscale-100'],
            ['grayscale-full'],
            ['not-a-grayscale-class'],
            ['grayscale-['],
            ['grayscale-50%'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the default grayscale (100%)
        $defaultGrayscale = GrayscaleClass::parse('grayscale');
        $this->assertInstanceOf(GrayscaleClass::class, $defaultGrayscale);
        $this->assertSame('.grayscale{--tw-grayscale:grayscale(100%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $defaultGrayscale->toCss());

        // Test no grayscale (0)
        $noGrayscale = GrayscaleClass::parse('grayscale-0');
        $this->assertInstanceOf(GrayscaleClass::class, $noGrayscale);
        $this->assertSame('.grayscale-0{--tw-grayscale:grayscale(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $noGrayscale->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = GrayscaleClass::parse('grayscale-[0.75]');
        $this->assertInstanceOf(GrayscaleClass::class, $decimalArbitrary);
        $this->assertSame('.grayscale-\[0\.75\]{--tw-grayscale:grayscale(0.75);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $decimalArbitrary->toCss());

        // Test an arbitrary value with percentage
        $percentageArbitrary = GrayscaleClass::parse('grayscale-[25%]');
        $this->assertInstanceOf(GrayscaleClass::class, $percentageArbitrary);
        $this->assertSame('.grayscale-\[25\%\]{--tw-grayscale:grayscale(25%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $percentageArbitrary->toCss());
    }
}
