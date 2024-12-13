<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\BackdropSepiaClass;

class BackdropSepiaTest extends TestCase
{
    #[DataProvider('standardBackdropSepiaProvider')]
    public function test_standard_backdrop_sepia(string $input, string $expected): void
    {
        $backdropSepiaClass = BackdropSepiaClass::parse($input);
        $this->assertInstanceOf(BackdropSepiaClass::class, $backdropSepiaClass);
        $this->assertSame($expected, $backdropSepiaClass->toCss());
    }

    public static function standardBackdropSepiaProvider(): array
    {
        return [
            ['backdrop-sepia-0', '.backdrop-sepia-0{--tw-backdrop-sepia:sepia(0);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-sepia', '.backdrop-sepia{--tw-backdrop-sepia:sepia(100%);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
        ];
    }

    #[DataProvider('arbitraryBackdropSepiaProvider')]
    public function test_arbitrary_backdrop_sepia(string $input, string $expected): void
    {
        $backdropSepiaClass = BackdropSepiaClass::parse($input);
        $this->assertInstanceOf(BackdropSepiaClass::class, $backdropSepiaClass);
        $this->assertSame($expected, $backdropSepiaClass->toCss());
    }

    public static function arbitraryBackdropSepiaProvider(): array
    {
        return [
            ['backdrop-sepia-[0.25]', '.backdrop-sepia-\[0\.25\]{--tw-backdrop-sepia:sepia(0.25);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-sepia-[.75]', '.backdrop-sepia-\[\.75\]{--tw-backdrop-sepia:sepia(.75);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-sepia-[50%]', '.backdrop-sepia-\[50\%\]{--tw-backdrop-sepia:sepia(50%);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
            ['backdrop-sepia-[1.5]', '.backdrop-sepia-\[1\.5\]{--tw-backdrop-sepia:sepia(1.5);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function test_invalid_inputs(string $input): void
    {
        $backdropSepiaClass = BackdropSepiaClass::parse($input);
        $this->assertNull($backdropSepiaClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['backdrop-sepia-'],
            ['backdrop-sepia-50'],
            ['backdrop-sepia-100'],
            ['backdrop-sepia-full'],
            ['not-a-backdrop-sepia-class'],
            ['backdrop-sepia-[2'],
            ['backdrop-sepia-2.5'],
        ];
    }

    public function test_edge_cases(): void
    {
        // Test the smallest predefined backdrop-sepia
        $smallestBackdropSepia = BackdropSepiaClass::parse('backdrop-sepia-0');
        $this->assertInstanceOf(BackdropSepiaClass::class, $smallestBackdropSepia);
        $this->assertSame('.backdrop-sepia-0{--tw-backdrop-sepia:sepia(0);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $smallestBackdropSepia->toCss());

        // Test the largest predefined backdrop-sepia
        $largestBackdropSepia = BackdropSepiaClass::parse('backdrop-sepia');
        $this->assertInstanceOf(BackdropSepiaClass::class, $largestBackdropSepia);
        $this->assertSame('.backdrop-sepia{--tw-backdrop-sepia:sepia(100%);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $largestBackdropSepia->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = BackdropSepiaClass::parse('backdrop-sepia-[0.33]');
        $this->assertInstanceOf(BackdropSepiaClass::class, $decimalArbitrary);
        $this->assertSame('.backdrop-sepia-\[0\.33\]{--tw-backdrop-sepia:sepia(0.33);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $decimalArbitrary->toCss());

        // Test an arbitrary value with a different unit
        $differentUnitArbitrary = BackdropSepiaClass::parse('backdrop-sepia-[75%]');
        $this->assertInstanceOf(BackdropSepiaClass::class, $differentUnitArbitrary);
        $this->assertSame('.backdrop-sepia-\[75\%\]{--tw-backdrop-sepia:sepia(75%);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}', $differentUnitArbitrary->toCss());
    }
}
