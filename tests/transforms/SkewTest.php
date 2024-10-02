<?php

namespace Raakkan\PhpTailwind\Tests\Transforms;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Transforms\SkewClass;
use PHPUnit\Framework\Attributes\DataProvider;

class SkewTest extends TestCase
{
    #[DataProvider('standardSkewProvider')]
    public function testStandardSkew(string $input, string $expected): void
    {
        $skewClass = SkewClass::parse($input);
        $this->assertInstanceOf(SkewClass::class, $skewClass);
        $this->assertSame($expected, $skewClass->toCss());
    }

    public static function standardSkewProvider(): array
    {
        return [
            ['skew-x-0', '.skew-x-0{--tw-skew-x:0deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-x-1', '.skew-x-1{--tw-skew-x:1deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-x-2', '.skew-x-2{--tw-skew-x:2deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-x-3', '.skew-x-3{--tw-skew-x:3deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-x-6', '.skew-x-6{--tw-skew-x:6deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-x-12', '.skew-x-12{--tw-skew-x:12deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-y-0', '.skew-y-0{--tw-skew-y:0deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-y-1', '.skew-y-1{--tw-skew-y:1deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-y-2', '.skew-y-2{--tw-skew-y:2deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-y-3', '.skew-y-3{--tw-skew-y:3deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-y-6', '.skew-y-6{--tw-skew-y:6deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-y-12', '.skew-y-12{--tw-skew-y:12deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
        ];
    }

    #[DataProvider('negativeSkewProvider')]
    public function testNegativeSkew(string $input, string $expected): void
    {
        $skewClass = SkewClass::parse($input);
        $this->assertInstanceOf(SkewClass::class, $skewClass);
        $this->assertSame($expected, $skewClass->toCss());
    }

    public static function negativeSkewProvider(): array
    {
        return [
            ['-skew-x-1', '.-skew-x-1{--tw-skew-x:-1deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-x-2', '.-skew-x-2{--tw-skew-x:-2deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-x-3', '.-skew-x-3{--tw-skew-x:-3deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-x-6', '.-skew-x-6{--tw-skew-x:-6deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-x-12', '.-skew-x-12{--tw-skew-x:-12deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-y-1', '.-skew-y-1{--tw-skew-y:-1deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-y-2', '.-skew-y-2{--tw-skew-y:-2deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-y-3', '.-skew-y-3{--tw-skew-y:-3deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-y-6', '.-skew-y-6{--tw-skew-y:-6deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-y-12', '.-skew-y-12{--tw-skew-y:-12deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
        ];
    }

    #[DataProvider('arbitrarySkewProvider')]
    public function testArbitrarySkew(string $input, string $expected): void
    {
        $skewClass = SkewClass::parse($input);
        $this->assertInstanceOf(SkewClass::class, $skewClass);
        $this->assertSame($expected, $skewClass->toCss());
    }

    public static function arbitrarySkewProvider(): array
    {
        return [
            ['skew-x-[14deg]', '.skew-x-\[14deg\]{--tw-skew-x:14deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['skew-y-[0.5turn]', '.skew-y-\[0\.5turn\]{--tw-skew-y:0.5turn;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-x-[23deg]', '.skew-x-\[-23deg\]{--tw-skew-x:-23deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-skew-y-[1.23rad]', '.skew-y-\[-1\.23rad\]{--tw-skew-y:-1.23rad;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $skewClass = SkewClass::parse($input);
        $this->assertNull($skewClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['skew'],
            ['skew-'],
            // ['skew-x'],
            // ['skew-y'],
            ['skew-x-4'],
            ['skew-y-13'],
            ['skew-z-12'],
            ['not-a-skew-class'],
            ['skew-x-['],
            ['skew-y-12deg'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the default skew (0deg)
        $defaultSkew = SkewClass::parse('skew-x-0');
        $this->assertInstanceOf(SkewClass::class, $defaultSkew);
        $this->assertSame('.skew-x-0{--tw-skew-x:0deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}', $defaultSkew->toCss());

        // Test maximum standard value (12deg)
        $maxStandardSkew = SkewClass::parse('skew-y-12');
        $this->assertInstanceOf(SkewClass::class, $maxStandardSkew);
        $this->assertSame('.skew-y-12{--tw-skew-y:12deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}', $maxStandardSkew->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = SkewClass::parse('skew-x-[10.5deg]');
        $this->assertInstanceOf(SkewClass::class, $decimalArbitrary);
        $this->assertSame('.skew-x-\[10\.5deg\]{--tw-skew-x:10.5deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}', $decimalArbitrary->toCss());

        // Test an arbitrary value with negative value
        $negativeArbitrary = SkewClass::parse('-skew-y-[45deg]');
        $this->assertInstanceOf(SkewClass::class, $negativeArbitrary);
        $this->assertSame('.skew-y-\[-45deg\]{--tw-skew-y:-45deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}', $negativeArbitrary->toCss());
    }
}