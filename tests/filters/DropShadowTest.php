<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\DropShadowClass;

class DropShadowTest extends TestCase
{
    #[DataProvider('standardDropShadowProvider')]
    public function testStandardDropShadows(string $input, string $expected): void
    {
        $dropShadowClass = DropShadowClass::parse($input);
        $this->assertInstanceOf(DropShadowClass::class, $dropShadowClass);
        $this->assertSame($expected, $dropShadowClass->toCss());
    }

    public static function standardDropShadowProvider(): array
    {
        return [
            ['drop-shadow-sm', '.drop-shadow-sm{--tw-drop-shadow:drop-shadow(0 1px 1px rgb(0 0 0 / 0.05));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['drop-shadow', '.drop-shadow-DEFAULT{--tw-drop-shadow:drop-shadow(0 1px 2px rgb(0 0 0 / 0.1)) drop-shadow(0 1px 1px rgb(0 0 0 / 0.06));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['drop-shadow-md', '.drop-shadow-md{--tw-drop-shadow:drop-shadow(0 4px 3px rgb(0 0 0 / 0.07)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.06));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['drop-shadow-lg', '.drop-shadow-lg{--tw-drop-shadow:drop-shadow(0 10px 8px rgb(0 0 0 / 0.04)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.1));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['drop-shadow-xl', '.drop-shadow-xl{--tw-drop-shadow:drop-shadow(0 20px 13px rgb(0 0 0 / 0.03)) drop-shadow(0 8px 5px rgb(0 0 0 / 0.08));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['drop-shadow-2xl', '.drop-shadow-2xl{--tw-drop-shadow:drop-shadow(0 25px 25px rgb(0 0 0 / 0.15));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['drop-shadow-none', '.drop-shadow-none{--tw-drop-shadow:drop-shadow(0 0 #0000);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    // TODO: box shadow arbitrary pending
    // #[DataProvider('arbitraryDropShadowProvider')]
    // public function testArbitraryDropShadows(string $input, string $expected): void
    // {
    //     $dropShadowClass = DropShadowClass::parse($input);
    //     $this->assertInstanceOf(DropShadowClass::class, $dropShadowClass);
    //     $this->assertSame($expected, $dropShadowClass->toCss());
    // }

    // public static function arbitraryDropShadowProvider(): array
    // {
    //     return [
    //         ['drop-shadow-[0_35px_35px_rgba(0,0,0,0.25)]', '.drop-shadow-\[0_35px_35px_rgba\(0\2c 0\2c 0\2c 0\.25\)\]{--tw-drop-shadow:drop-shadow(0 35px 35px rgba(0,0,0,0.25));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
    //         ['drop-shadow-[0_5px_5px_red]', '.drop-shadow-\[0_5px_5px_red\]{--tw-drop-shadow:drop-shadow(0 5px 5px red);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
    //     ];
    // }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $dropShadowClass = DropShadowClass::parse($input);
        $this->assertNull($dropShadowClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['drop-shadow-'],
            ['drop-shadow-xs'],
            ['drop-shadow-3xl'],
            ['drop-shadow-medium'],
            ['not-a-drop-shadow-class'],
            // ['drop-shadow-[invalid]'],
            ['drop-shadow-[2rem'],
            ['drop-shadow-2px'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the default drop-shadow
        $defaultDropShadow = DropShadowClass::parse('drop-shadow');
        $this->assertInstanceOf(DropShadowClass::class, $defaultDropShadow);
        $this->assertSame('.drop-shadow-DEFAULT{--tw-drop-shadow:drop-shadow(0 1px 2px rgb(0 0 0 / 0.1)) drop-shadow(0 1px 1px rgb(0 0 0 / 0.06));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $defaultDropShadow->toCss());

        // Test the smallest predefined drop-shadow
        $smallestDropShadow = DropShadowClass::parse('drop-shadow-sm');
        $this->assertInstanceOf(DropShadowClass::class, $smallestDropShadow);
        $this->assertSame('.drop-shadow-sm{--tw-drop-shadow:drop-shadow(0 1px 1px rgb(0 0 0 / 0.05));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $smallestDropShadow->toCss());

        // Test the largest predefined drop-shadow
        $largestDropShadow = DropShadowClass::parse('drop-shadow-2xl');
        $this->assertInstanceOf(DropShadowClass::class, $largestDropShadow);
        $this->assertSame('.drop-shadow-2xl{--tw-drop-shadow:drop-shadow(0 25px 25px rgb(0 0 0 / 0.15));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $largestDropShadow->toCss());

        // Test an arbitrary value with multiple shadows
        // $multiShadowArbitrary = DropShadowClass::parse('drop-shadow-[0_10px_8px_rgb(0,0,0,0.04),0_4px_3px_rgb(0,0,0,0.1)]');
        // $this->assertInstanceOf(DropShadowClass::class, $multiShadowArbitrary);
        // $this->assertSame('.drop-shadow-\[0_10px_8px_rgb\(0\2c 0\2c 0\2c 0\.04\)\2c 0_4px_3px_rgb\(0\2c 0\2c 0\2c 0\.1\)\]{--tw-drop-shadow:drop-shadow(0 10px 8px rgb(0,0,0,0.04),0 4px 3px rgb(0,0,0,0.1));filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $multiShadowArbitrary->toCss());

        // Test an arbitrary value with a different unit
        // $differentUnitArbitrary = DropShadowClass::parse('drop-shadow-[2em_2em_5em_#ff0000]');
        // $this->assertInstanceOf(DropShadowClass::class, $differentUnitArbitrary);
        // $this->assertSame('.drop-shadow-\[2em_2em_5em_\#ff0000\]{--tw-drop-shadow:drop-shadow(2em 2em 5em #ff0000);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $differentUnitArbitrary->toCss());
    }
}
