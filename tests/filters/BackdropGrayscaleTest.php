<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\BackdropGrayscaleClass;

class BackdropGrayscaleTest extends TestCase
{
    #[DataProvider('standardBackdropGrayscaleProvider')]
    public function test_standard_backdrop_grayscale(string $input, string $expected): void
    {
        $backdropGrayscaleClass = BackdropGrayscaleClass::parse($input);
        $this->assertInstanceOf(BackdropGrayscaleClass::class, $backdropGrayscaleClass);
        $this->assertSame($expected, $backdropGrayscaleClass->toCss());
    }

    public static function standardBackdropGrayscaleProvider(): array
    {
        return [
            ['backdrop-grayscale', '.backdrop-grayscale{--tw-backdrop-grayscale:grayscale(100%);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-grayscale-0', '.backdrop-grayscale-0{--tw-backdrop-grayscale:grayscale(0);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
        ];
    }

    #[DataProvider('arbitraryBackdropGrayscaleProvider')]
    public function test_arbitrary_backdrop_grayscale(string $input, string $expected): void
    {
        $backdropGrayscaleClass = BackdropGrayscaleClass::parse($input);
        $this->assertInstanceOf(BackdropGrayscaleClass::class, $backdropGrayscaleClass);
        $this->assertSame($expected, $backdropGrayscaleClass->toCss());
    }

    public static function arbitraryBackdropGrayscaleProvider(): array
    {
        return [
            ['backdrop-grayscale-[0.5]', '.backdrop-grayscale-\[0\.5\]{--tw-backdrop-grayscale:grayscale(0.5);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-grayscale-[50%]', '.backdrop-grayscale-\[50\%\]{--tw-backdrop-grayscale:grayscale(50%);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-grayscale-[.25]', '.backdrop-grayscale-\[\.25\]{--tw-backdrop-grayscale:grayscale(.25);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-grayscale-[75%]', '.backdrop-grayscale-\[75\%\]{--tw-backdrop-grayscale:grayscale(75%);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function test_invalid_inputs(string $input): void
    {
        $backdropGrayscaleClass = BackdropGrayscaleClass::parse($input);
        $this->assertNull($backdropGrayscaleClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['backdrop-grayscale-'],
            ['backdrop-grayscale-1'],
            ['backdrop-grayscale-100'],
            ['backdrop-grayscale-full'],
            ['not-a-backdrop-grayscale-class'],
            ['backdrop-grayscale-['],
            ['backdrop-grayscale-50%'],
        ];
    }

    public function test_edge_cases(): void
    {
        // Test the default backdrop-grayscale (100%)
        $defaultBackdropGrayscale = BackdropGrayscaleClass::parse('backdrop-grayscale');
        $this->assertInstanceOf(BackdropGrayscaleClass::class, $defaultBackdropGrayscale);
        $this->assertSame('.backdrop-grayscale{--tw-backdrop-grayscale:grayscale(100%);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $defaultBackdropGrayscale->toCss());

        // Test no backdrop-grayscale (0)
        $noBackdropGrayscale = BackdropGrayscaleClass::parse('backdrop-grayscale-0');
        $this->assertInstanceOf(BackdropGrayscaleClass::class, $noBackdropGrayscale);
        $this->assertSame('.backdrop-grayscale-0{--tw-backdrop-grayscale:grayscale(0);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $noBackdropGrayscale->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = BackdropGrayscaleClass::parse('backdrop-grayscale-[0.75]');
        $this->assertInstanceOf(BackdropGrayscaleClass::class, $decimalArbitrary);
        $this->assertSame('.backdrop-grayscale-\[0\.75\]{--tw-backdrop-grayscale:grayscale(0.75);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $decimalArbitrary->toCss());

        // Test an arbitrary value with percentage
        $percentageArbitrary = BackdropGrayscaleClass::parse('backdrop-grayscale-[25%]');
        $this->assertInstanceOf(BackdropGrayscaleClass::class, $percentageArbitrary);
        $this->assertSame('.backdrop-grayscale-\[25\%\]{--tw-backdrop-grayscale:grayscale(25%);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $percentageArbitrary->toCss());
    }
}
