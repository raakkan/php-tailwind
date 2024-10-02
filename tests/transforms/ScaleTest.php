<?php

namespace Raakkan\PhpTailwind\Tests\Transforms;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Transforms\ScaleClass;
use PHPUnit\Framework\Attributes\DataProvider;

class ScaleTest extends TestCase
{
    #[DataProvider('scaleClassProvider')]
    public function testScaleClass(string $input, string $expected): void
    {
        $scaleClass = ScaleClass::parse($input);
        $this->assertInstanceOf(ScaleClass::class, $scaleClass);
        $this->assertSame($expected, $scaleClass->toCss());
    }

    public static function scaleClassProvider(): array
    {
        return [
            // All axes
            ['scale-0', ".scale-0{--tw-scale-x:0;--tw-scale-y:0;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['scale-50', ".scale-50{--tw-scale-x:.5;--tw-scale-y:.5;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['scale-100', ".scale-100{--tw-scale-x:1;--tw-scale-y:1;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['scale-150', ".scale-150{--tw-scale-x:1.5;--tw-scale-y:1.5;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],

            // X-axis
            ['scale-x-0', ".scale-x-0{--tw-scale-x:0;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['scale-x-75', ".scale-x-75{--tw-scale-x:.75;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['scale-x-125', ".scale-x-125{--tw-scale-x:1.25;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],

            // Y-axis
            ['scale-y-0', ".scale-y-0{--tw-scale-y:0;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['scale-y-90', ".scale-y-90{--tw-scale-y:.9;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['scale-y-110', ".scale-y-110{--tw-scale-y:1.1;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
        ];
    }

    #[DataProvider('arbitraryScaleClassProvider')]
    public function testArbitraryScaleClass(string $input, string $expected): void
    {
        $scaleClass = ScaleClass::parse($input);
        $this->assertInstanceOf(ScaleClass::class, $scaleClass);
        $this->assertSame($expected, $scaleClass->toCss());
    }

    public static function arbitraryScaleClassProvider(): array
    {
        return [
            ['scale-[0.25]', ".scale-[0.25]{--tw-scale-x:0.25;--tw-scale-y:0.25;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['scale-[1.7]', ".scale-[1.7]{--tw-scale-x:1.7;--tw-scale-y:1.7;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['scale-x-[0.8]', ".scale-x-[0.8]{--tw-scale-x:0.8;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['scale-y-[2.5]', ".scale-y-[2.5]{--tw-scale-y:2.5;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
        ];
    }

    public function testInvalidScaleClass(): void
    {
        $this->assertNull(ScaleClass::parse('invalid-class'));
    }

    #[DataProvider('invalidScaleValueProvider')]
    public function testScaleClassWithInvalidValue(string $input): void
    {
        $scaleClass = ScaleClass::parse($input);
        $this->assertInstanceOf(ScaleClass::class, $scaleClass);
        $this->assertSame('', $scaleClass->toCss());
    }

    public static function invalidScaleValueProvider(): array
    {
        return [
            ['scale-25'],
            ['scale-200'],
            ['scale-x-60'],
            ['scale-y-175'],
        ];
    }

    #[DataProvider('invalidArbitraryScaleClassProvider')]
    public function testInvalidArbitraryScaleClass(string $input): void
    {
        $scaleClass = ScaleClass::parse($input);
        $this->assertInstanceOf(ScaleClass::class, $scaleClass);
        $this->assertSame('', $scaleClass->toCss());
    }

    public static function invalidArbitraryScaleClassProvider(): array
    {
        return [
            ['scale-[invalid]'],
            ['scale-[10px]'],
            ['scale-[em]'],
            ['scale-x-[]'],
            // ['scale-y-[1.5'],
            // ['scale-1.5]'],
        ];
    }
}