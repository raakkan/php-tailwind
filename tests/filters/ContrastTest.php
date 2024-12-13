<?php

namespace Raakkan\PhpTailwind\Tests\Filters;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Filters\ContrastClass;

class ContrastTest extends TestCase
{
    #[DataProvider('standardContrastProvider')]
    public function test_standard_contrast(string $input, string $expected): void
    {
        $contrastClass = ContrastClass::parse($input);
        $this->assertInstanceOf(ContrastClass::class, $contrastClass);
        $this->assertSame($expected, $contrastClass->toCss());
    }

    public static function standardContrastProvider(): array
    {
        return [
            ['contrast-0', '.contrast-0{--tw-contrast:contrast(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['contrast-50', '.contrast-50{--tw-contrast:contrast(.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['contrast-75', '.contrast-75{--tw-contrast:contrast(.75);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['contrast-100', '.contrast-100{--tw-contrast:contrast(1);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['contrast-125', '.contrast-125{--tw-contrast:contrast(1.25);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['contrast-150', '.contrast-150{--tw-contrast:contrast(1.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['contrast-200', '.contrast-200{--tw-contrast:contrast(2);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('arbitraryContrastProvider')]
    public function test_arbitrary_contrast(string $input, string $expected): void
    {
        $contrastClass = ContrastClass::parse($input);
        $this->assertInstanceOf(ContrastClass::class, $contrastClass);
        $this->assertSame($expected, $contrastClass->toCss());
    }

    public static function arbitraryContrastProvider(): array
    {
        return [
            ['contrast-[0.25]', '.contrast-\[0\.25\]{--tw-contrast:contrast(0.25);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['contrast-[1.75]', '.contrast-\[1\.75\]{--tw-contrast:contrast(1.75);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['contrast-[80%]', '.contrast-\[80\%\]{--tw-contrast:contrast(80%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
            ['contrast-[2.5]', '.contrast-\[2\.5\]{--tw-contrast:contrast(2.5);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function test_invalid_inputs(string $input): void
    {
        $contrastClass = ContrastClass::parse($input);
        $this->assertNull($contrastClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['contrast-'],
            ['contrast-25'],
            ['contrast-300'],
            ['contrast-medium'],
            ['not-a-contrast-class'],
            ['contrast-[2'],
            ['contrast-2.5'],
        ];
    }

    public function test_edge_cases(): void
    {
        // Test the smallest predefined contrast
        $smallestContrast = ContrastClass::parse('contrast-0');
        $this->assertInstanceOf(ContrastClass::class, $smallestContrast);
        $this->assertSame('.contrast-0{--tw-contrast:contrast(0);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $smallestContrast->toCss());

        // Test the largest predefined contrast
        $largestContrast = ContrastClass::parse('contrast-200');
        $this->assertInstanceOf(ContrastClass::class, $largestContrast);
        $this->assertSame('.contrast-200{--tw-contrast:contrast(2);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $largestContrast->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = ContrastClass::parse('contrast-[1.33]');
        $this->assertInstanceOf(ContrastClass::class, $decimalArbitrary);
        $this->assertSame('.contrast-\[1\.33\]{--tw-contrast:contrast(1.33);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $decimalArbitrary->toCss());

        // Test an arbitrary value with a different unit
        $differentUnitArbitrary = ContrastClass::parse('contrast-[120%]');
        $this->assertInstanceOf(ContrastClass::class, $differentUnitArbitrary);
        $this->assertSame('.contrast-\[120\%\]{--tw-contrast:contrast(120%);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}', $differentUnitArbitrary->toCss());
    }
}
