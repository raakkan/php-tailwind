<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\BackdropSaturateClass;

class BackdropSaturateTest extends TestCase
{
    #[DataProvider('standardBackdropSaturateProvider')]
    public function testStandardBackdropSaturate(string $input, string $expected): void
    {
        $backdropSaturateClass = BackdropSaturateClass::parse($input);
        $this->assertInstanceOf(BackdropSaturateClass::class, $backdropSaturateClass);
        $this->assertSame($expected, $backdropSaturateClass->toCss());
    }

    public static function standardBackdropSaturateProvider(): array
    {
        return [
            ['backdrop-saturate-0', '.backdrop-saturate-0{--tw-backdrop-saturate:saturate(0);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-saturate-50', '.backdrop-saturate-50{--tw-backdrop-saturate:saturate(.5);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-saturate-100', '.backdrop-saturate-100{--tw-backdrop-saturate:saturate(1);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-saturate-150', '.backdrop-saturate-150{--tw-backdrop-saturate:saturate(1.5);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-saturate-200', '.backdrop-saturate-200{--tw-backdrop-saturate:saturate(2);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
        ];
    }

    #[DataProvider('arbitraryBackdropSaturateProvider')]
    public function testArbitraryBackdropSaturate(string $input, string $expected): void
    {
        $backdropSaturateClass = BackdropSaturateClass::parse($input);
        $this->assertInstanceOf(BackdropSaturateClass::class, $backdropSaturateClass);
        $this->assertSame($expected, $backdropSaturateClass->toCss());
    }

    public static function arbitraryBackdropSaturateProvider(): array
    {
        return [
            ['backdrop-saturate-[.25]', '.backdrop-saturate-\[\.25\]{--tw-backdrop-saturate:saturate(.25);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-saturate-[1.75]', '.backdrop-saturate-\[1\.75\]{--tw-backdrop-saturate:saturate(1.75);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-saturate-[3]', '.backdrop-saturate-\[3\]{--tw-backdrop-saturate:saturate(3);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $backdropSaturateClass = BackdropSaturateClass::parse($input);
        $this->assertNull($backdropSaturateClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['backdrop-saturate'],
            ['backdrop-saturate-'],
            ['backdrop-saturate-25'],
            ['backdrop-saturate-75'],
            ['backdrop-saturate-250'],
            ['not-a-backdrop-saturate-class'],
            ['backdrop-saturate-['],
            ['backdrop-saturate-50%'],
            ['saturate-100'], // Missing 'backdrop-' prefix
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the default backdrop-saturate (100%)
        $defaultBackdropSaturate = BackdropSaturateClass::parse('backdrop-saturate-100');
        $this->assertInstanceOf(BackdropSaturateClass::class, $defaultBackdropSaturate);
        $this->assertSame('.backdrop-saturate-100{--tw-backdrop-saturate:saturate(1);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $defaultBackdropSaturate->toCss());

        // Test minimum standard value (0%)
        $minStandardBackdropSaturate = BackdropSaturateClass::parse('backdrop-saturate-0');
        $this->assertInstanceOf(BackdropSaturateClass::class, $minStandardBackdropSaturate);
        $this->assertSame('.backdrop-saturate-0{--tw-backdrop-saturate:saturate(0);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $minStandardBackdropSaturate->toCss());

        // Test maximum standard value (200%)
        $maxStandardBackdropSaturate = BackdropSaturateClass::parse('backdrop-saturate-200');
        $this->assertInstanceOf(BackdropSaturateClass::class, $maxStandardBackdropSaturate);
        $this->assertSame('.backdrop-saturate-200{--tw-backdrop-saturate:saturate(2);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $maxStandardBackdropSaturate->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = BackdropSaturateClass::parse('backdrop-saturate-[1.23]');
        $this->assertInstanceOf(BackdropSaturateClass::class, $decimalArbitrary);
        $this->assertSame('.backdrop-saturate-\[1\.23\]{--tw-backdrop-saturate:saturate(1.23);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $decimalArbitrary->toCss());

        // Test an arbitrary value greater than 200%
        $highArbitrary = BackdropSaturateClass::parse('backdrop-saturate-[2.5]');
        $this->assertInstanceOf(BackdropSaturateClass::class, $highArbitrary);
        $this->assertSame('.backdrop-saturate-\[2\.5\]{--tw-backdrop-saturate:saturate(2.5);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $highArbitrary->toCss());
    }
}
