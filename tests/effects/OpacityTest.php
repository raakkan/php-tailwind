<?php

namespace Raakkan\PhpTailwind\Tests\Effects;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Effects\OpacityClass;
use PHPUnit\Framework\Attributes\DataProvider;

class OpacityTest extends TestCase
{
    #[DataProvider('standardOpacityProvider')]
    public function testStandardOpacities(string $input, string $expected): void
    {
        $opacityClass = OpacityClass::parse($input);
        $this->assertInstanceOf(OpacityClass::class, $opacityClass);
        $this->assertSame($expected, $opacityClass->toCss());
    }

    public static function standardOpacityProvider(): array
    {
        return [
            ['opacity-0', '.opacity-0{opacity:0;}'],
            ['opacity-5', '.opacity-5{opacity:0.05;}'],
            ['opacity-10', '.opacity-10{opacity:0.1;}'],
            ['opacity-20', '.opacity-20{opacity:0.2;}'],
            ['opacity-25', '.opacity-25{opacity:0.25;}'],
            ['opacity-30', '.opacity-30{opacity:0.3;}'],
            ['opacity-40', '.opacity-40{opacity:0.4;}'],
            ['opacity-50', '.opacity-50{opacity:0.5;}'],
            ['opacity-60', '.opacity-60{opacity:0.6;}'],
            ['opacity-70', '.opacity-70{opacity:0.7;}'],
            ['opacity-75', '.opacity-75{opacity:0.75;}'],
            ['opacity-80', '.opacity-80{opacity:0.8;}'],
            ['opacity-90', '.opacity-90{opacity:0.9;}'],
            ['opacity-95', '.opacity-95{opacity:0.95;}'],
            ['opacity-100', '.opacity-100{opacity:1;}'],
            // Additional values
            ['opacity-15', '.opacity-15{opacity:0.15;}'],
            ['opacity-35', '.opacity-35{opacity:0.35;}'],
            ['opacity-45', '.opacity-45{opacity:0.45;}'],
            ['opacity-55', '.opacity-55{opacity:0.55;}'],
            ['opacity-65', '.opacity-65{opacity:0.65;}'],
            ['opacity-85', '.opacity-85{opacity:0.85;}'],
        ];
    }

    #[DataProvider('arbitraryOpacityProvider')]
    public function testArbitraryOpacities(string $input, string $expected): void
    {
        $opacityClass = OpacityClass::parse($input);
        $this->assertInstanceOf(OpacityClass::class, $opacityClass);
        $this->assertSame($expected, $opacityClass->toCss());
    }

    public static function arbitraryOpacityProvider(): array
    {
        return [
            ['opacity-[0.67]', '.opacity-\[0\.67\]{opacity:0.67;}'],
            ['opacity-[0.33]', '.opacity-\[0\.33\]{opacity:0.33;}'],
            ['opacity-[0.99]', '.opacity-\[0\.99\]{opacity:0.99;}'],
            ['opacity-[0.01]', '.opacity-\[0\.01\]{opacity:0.01;}'],
            ['opacity-[0]', '.opacity-\[0\]{opacity:0;}'],
            ['opacity-[1]', '.opacity-\[1\]{opacity:1;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $opacityClass = OpacityClass::parse($input);
        $this->assertNull($opacityClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['opacity'],
            ['opacity-'],
            ['opacity-101'],
            ['opacity--10'],
            ['opacity-3'],
            ['opacity-1000'],
            ['not-an-opacity-class'],
            // ['opacity-[invalid]'],
            // ['opacity-[1.1]'],
            // ['opacity-[2]'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the lowest valid opacity
        $lowestOpacity = OpacityClass::parse('opacity-0');
        $this->assertInstanceOf(OpacityClass::class, $lowestOpacity);
        $this->assertSame('.opacity-0{opacity:0;}', $lowestOpacity->toCss());

        // Test the highest valid opacity
        $highestOpacity = OpacityClass::parse('opacity-100');
        $this->assertInstanceOf(OpacityClass::class, $highestOpacity);
        $this->assertSame('.opacity-100{opacity:1;}', $highestOpacity->toCss());

        // Test an arbitrary value at the lower bound
        $lowerBoundArbitrary = OpacityClass::parse('opacity-[0.001]');
        $this->assertInstanceOf(OpacityClass::class, $lowerBoundArbitrary);
        $this->assertSame('.opacity-\[0\.001\]{opacity:0.001;}', $lowerBoundArbitrary->toCss());

        // Test an arbitrary value at the upper bound
        $upperBoundArbitrary = OpacityClass::parse('opacity-[0.999]');
        $this->assertInstanceOf(OpacityClass::class, $upperBoundArbitrary);
        $this->assertSame('.opacity-\[0\.999\]{opacity:0.999;}', $upperBoundArbitrary->toCss());
    }
}