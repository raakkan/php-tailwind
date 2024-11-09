<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\BackdropHueRotateClass;

class BackdropHueRotateTest extends TestCase
{
    #[DataProvider('standardBackdropHueRotateProvider')]
    public function testStandardBackdropHueRotate(string $input, string $expected): void
    {
        $backdropHueRotateClass = BackdropHueRotateClass::parse($input);
        $this->assertInstanceOf(BackdropHueRotateClass::class, $backdropHueRotateClass);
        $this->assertSame($expected, $backdropHueRotateClass->toCss());
    }

    public static function standardBackdropHueRotateProvider(): array
    {
        return [
            ['backdrop-hue-rotate-0', '.backdrop-hue-rotate-0{--tw-backdrop-hue-rotate:hue-rotate(0deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-hue-rotate-15', '.backdrop-hue-rotate-15{--tw-backdrop-hue-rotate:hue-rotate(15deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-hue-rotate-30', '.backdrop-hue-rotate-30{--tw-backdrop-hue-rotate:hue-rotate(30deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-hue-rotate-60', '.backdrop-hue-rotate-60{--tw-backdrop-hue-rotate:hue-rotate(60deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-hue-rotate-90', '.backdrop-hue-rotate-90{--tw-backdrop-hue-rotate:hue-rotate(90deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-hue-rotate-180', '.backdrop-hue-rotate-180{--tw-backdrop-hue-rotate:hue-rotate(180deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
        ];
    }

    #[DataProvider('negativeBackdropHueRotateProvider')]
    public function testNegativeBackdropHueRotate(string $input, string $expected): void
    {
        $backdropHueRotateClass = BackdropHueRotateClass::parse($input);
        $this->assertInstanceOf(BackdropHueRotateClass::class, $backdropHueRotateClass);
        $this->assertSame($expected, $backdropHueRotateClass->toCss());
    }

    public static function negativeBackdropHueRotateProvider(): array
    {
        return [
            ['-backdrop-hue-rotate-15', '.backdrop-hue-rotate--15{--tw-backdrop-hue-rotate:hue-rotate(-15deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['-backdrop-hue-rotate-30', '.backdrop-hue-rotate--30{--tw-backdrop-hue-rotate:hue-rotate(-30deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['-backdrop-hue-rotate-60', '.backdrop-hue-rotate--60{--tw-backdrop-hue-rotate:hue-rotate(-60deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['-backdrop-hue-rotate-90', '.backdrop-hue-rotate--90{--tw-backdrop-hue-rotate:hue-rotate(-90deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['-backdrop-hue-rotate-180', '.backdrop-hue-rotate--180{--tw-backdrop-hue-rotate:hue-rotate(-180deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
        ];
    }

    #[DataProvider('arbitraryBackdropHueRotateProvider')]
    public function testArbitraryBackdropHueRotate(string $input, string $expected): void
    {
        $backdropHueRotateClass = BackdropHueRotateClass::parse($input);
        $this->assertInstanceOf(BackdropHueRotateClass::class, $backdropHueRotateClass);
        $this->assertSame($expected, $backdropHueRotateClass->toCss());
    }

    public static function arbitraryBackdropHueRotateProvider(): array
    {
        return [
            ['backdrop-hue-rotate-[23deg]', '.backdrop-hue-rotate-\[23deg\]{--tw-backdrop-hue-rotate:hue-rotate(23deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-hue-rotate-[2.3rad]', '.backdrop-hue-rotate-\[2\.3rad\]{--tw-backdrop-hue-rotate:hue-rotate(2.3rad);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-hue-rotate-[0.5turn]', '.backdrop-hue-rotate-\[0\.5turn\]{--tw-backdrop-hue-rotate:hue-rotate(0.5turn);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['-backdrop-hue-rotate-[120deg]', '.backdrop-hue-rotate-\[-120deg\]{--tw-backdrop-hue-rotate:hue-rotate(-120deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $backdropHueRotateClass = BackdropHueRotateClass::parse($input);
        $this->assertNull($backdropHueRotateClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            // ['backdrop-hue-rotate'],
            ['backdrop-hue-rotate-'],
            ['backdrop-hue-rotate-1'],
            ['backdrop-hue-rotate-45'],
            ['backdrop-hue-rotate-full'],
            ['not-a-backdrop-hue-rotate-class'],
            ['backdrop-hue-rotate-['],
            ['backdrop-hue-rotate-50deg'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the default backdrop-hue-rotate (0deg)
        $defaultBackdropHueRotate = BackdropHueRotateClass::parse('backdrop-hue-rotate-0');
        $this->assertInstanceOf(BackdropHueRotateClass::class, $defaultBackdropHueRotate);
        $this->assertSame('.backdrop-hue-rotate-0{--tw-backdrop-hue-rotate:hue-rotate(0deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $defaultBackdropHueRotate->toCss());

        // Test maximum standard value (180deg)
        $maxStandardBackdropHueRotate = BackdropHueRotateClass::parse('backdrop-hue-rotate-180');
        $this->assertInstanceOf(BackdropHueRotateClass::class, $maxStandardBackdropHueRotate);
        $this->assertSame('.backdrop-hue-rotate-180{--tw-backdrop-hue-rotate:hue-rotate(180deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $maxStandardBackdropHueRotate->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = BackdropHueRotateClass::parse('backdrop-hue-rotate-[12.5deg]');
        $this->assertInstanceOf(BackdropHueRotateClass::class, $decimalArbitrary);
        $this->assertSame('.backdrop-hue-rotate-\[12\.5deg\]{--tw-backdrop-hue-rotate:hue-rotate(12.5deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $decimalArbitrary->toCss());

        // Test an arbitrary value with negative value
        $negativeArbitrary = BackdropHueRotateClass::parse('-backdrop-hue-rotate-[45deg]');
        $this->assertInstanceOf(BackdropHueRotateClass::class, $negativeArbitrary);
        $this->assertSame('.backdrop-hue-rotate-\[-45deg\]{--tw-backdrop-hue-rotate:hue-rotate(-45deg);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $negativeArbitrary->toCss());
    }
}
