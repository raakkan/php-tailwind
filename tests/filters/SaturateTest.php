<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\SaturateClass;
use PHPUnit\Framework\Attributes\DataProvider;

class SaturateTest extends TestCase
{
    #[DataProvider('standardSaturateProvider')]
    public function testStandardSaturate(string $input, string $expected): void
    {
        $saturateClass = SaturateClass::parse($input);
        $this->assertInstanceOf(SaturateClass::class, $saturateClass);
        $this->assertSame($expected, $saturateClass->toCss());
    }

    public static function standardSaturateProvider(): array
    {
        return [
            ['saturate-0', '.saturate-0{--tw-saturate:saturate(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['saturate-50', '.saturate-50{--tw-saturate:saturate(.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['saturate-100', '.saturate-100{--tw-saturate:saturate(1);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['saturate-150', '.saturate-150{--tw-saturate:saturate(1.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['saturate-200', '.saturate-200{--tw-saturate:saturate(2);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('arbitrarySaturateProvider')]
    public function testArbitrarySaturate(string $input, string $expected): void
    {
        $saturateClass = SaturateClass::parse($input);
        $this->assertInstanceOf(SaturateClass::class, $saturateClass);
        $this->assertSame($expected, $saturateClass->toCss());
    }

    public static function arbitrarySaturateProvider(): array
    {
        return [
            ['saturate-[.25]', '.saturate-\[\.25\]{--tw-saturate:saturate(.25);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['saturate-[1.75]', '.saturate-\[1\.75\]{--tw-saturate:saturate(1.75);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['saturate-[3]', '.saturate-\[3\]{--tw-saturate:saturate(3);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $saturateClass = SaturateClass::parse($input);
        $this->assertNull($saturateClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['saturate'],
            ['saturate-'],
            ['saturate-25'],
            ['saturate-75'],
            ['saturate-250'],
            ['not-a-saturate-class'],
            ['saturate-['],
            ['saturate-50%'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the default saturate (100%)
        $defaultSaturate = SaturateClass::parse('saturate-100');
        $this->assertInstanceOf(SaturateClass::class, $defaultSaturate);
        $this->assertSame('.saturate-100{--tw-saturate:saturate(1);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $defaultSaturate->toCss());

        // Test minimum standard value (0%)
        $minStandardSaturate = SaturateClass::parse('saturate-0');
        $this->assertInstanceOf(SaturateClass::class, $minStandardSaturate);
        $this->assertSame('.saturate-0{--tw-saturate:saturate(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $minStandardSaturate->toCss());

        // Test maximum standard value (200%)
        $maxStandardSaturate = SaturateClass::parse('saturate-200');
        $this->assertInstanceOf(SaturateClass::class, $maxStandardSaturate);
        $this->assertSame('.saturate-200{--tw-saturate:saturate(2);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $maxStandardSaturate->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = SaturateClass::parse('saturate-[1.23]');
        $this->assertInstanceOf(SaturateClass::class, $decimalArbitrary);
        $this->assertSame('.saturate-\[1\.23\]{--tw-saturate:saturate(1.23);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $decimalArbitrary->toCss());

        // Test an arbitrary value greater than 200%
        $highArbitrary = SaturateClass::parse('saturate-[2.5]');
        $this->assertInstanceOf(SaturateClass::class, $highArbitrary);
        $this->assertSame('.saturate-\[2\.5\]{--tw-saturate:saturate(2.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $highArbitrary->toCss());
    }
}