<?php

namespace Raakkan\PhpTailwind\Tests\Transforms;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Transforms\RotateClass;
use PHPUnit\Framework\Attributes\DataProvider;

class RotateTest extends TestCase
{
    #[DataProvider('standardRotateProvider')]
    public function testStandardRotate(string $input, string $expected): void
    {
        $rotateClass = RotateClass::parse($input);
        $this->assertInstanceOf(RotateClass::class, $rotateClass);
        $this->assertSame($expected, $rotateClass->toCss());
    }

    public static function standardRotateProvider(): array
    {
        return [
            ['rotate-0', '.rotate-0{--tw-rotate:0deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['rotate-1', '.rotate-1{--tw-rotate:1deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['rotate-2', '.rotate-2{--tw-rotate:2deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['rotate-3', '.rotate-3{--tw-rotate:3deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['rotate-6', '.rotate-6{--tw-rotate:6deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['rotate-12', '.rotate-12{--tw-rotate:12deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['rotate-45', '.rotate-45{--tw-rotate:45deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['rotate-90', '.rotate-90{--tw-rotate:90deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['rotate-180', '.rotate-180{--tw-rotate:180deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
        ];
    }

    #[DataProvider('negativeRotateProvider')]
    public function testNegativeRotate(string $input, string $expected): void
    {
        $rotateClass = RotateClass::parse($input);
        $this->assertInstanceOf(RotateClass::class, $rotateClass);
        $this->assertSame($expected, $rotateClass->toCss());
    }

    public static function negativeRotateProvider(): array
    {
        return [
            ['-rotate-1', '.rotate--1{--tw-rotate:-1deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-rotate-2', '.rotate--2{--tw-rotate:-2deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-rotate-3', '.rotate--3{--tw-rotate:-3deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-rotate-6', '.rotate--6{--tw-rotate:-6deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-rotate-12', '.rotate--12{--tw-rotate:-12deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-rotate-45', '.rotate--45{--tw-rotate:-45deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-rotate-90', '.rotate--90{--tw-rotate:-90deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-rotate-180', '.rotate--180{--tw-rotate:-180deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
        ];
    }

    #[DataProvider('arbitraryRotateProvider')]
    public function testArbitraryRotate(string $input, string $expected): void
    {
        $rotateClass = RotateClass::parse($input);
        $this->assertInstanceOf(RotateClass::class, $rotateClass);
        $this->assertSame($expected, $rotateClass->toCss());
    }

    public static function arbitraryRotateProvider(): array
    {
        return [
            ['rotate-[23deg]', '.rotate-\[23deg\]{--tw-rotate:23deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['rotate-[2.3rad]', '.rotate-\[2\.3rad\]{--tw-rotate:2.3rad;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['rotate-[0.5turn]', '.rotate-\[0\.5turn\]{--tw-rotate:0.5turn;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-rotate-[120deg]', '.rotate-\[-120deg\]{--tw-rotate:-120deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $rotateClass = RotateClass::parse($input);
        $this->assertNull($rotateClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            // ['rotate'],
            ['rotate-'],
            ['rotate-4'],
            ['rotate-13'],
            ['rotate-full'],
            ['not-a-rotate-class'],
            ['rotate-['],
            ['rotate-50deg'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test the default rotate (0deg)
        $defaultRotate = RotateClass::parse('rotate-0');
        $this->assertInstanceOf(RotateClass::class, $defaultRotate);
        $this->assertSame('.rotate-0{--tw-rotate:0deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}', $defaultRotate->toCss());

        // Test maximum standard value (180deg)
        $maxStandardRotate = RotateClass::parse('rotate-180');
        $this->assertInstanceOf(RotateClass::class, $maxStandardRotate);
        $this->assertSame('.rotate-180{--tw-rotate:180deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}', $maxStandardRotate->toCss());

        // Test an arbitrary value with decimals
        $decimalArbitrary = RotateClass::parse('rotate-[12.5deg]');
        $this->assertInstanceOf(RotateClass::class, $decimalArbitrary);
        $this->assertSame('.rotate-\[12\.5deg\]{--tw-rotate:12.5deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}', $decimalArbitrary->toCss());

        // Test an arbitrary value with negative value
        $negativeArbitrary = RotateClass::parse('-rotate-[45deg]');
        $this->assertInstanceOf(RotateClass::class, $negativeArbitrary);
        $this->assertSame('.rotate-\[-45deg\]{--tw-rotate:-45deg;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}', $negativeArbitrary->toCss());
    }
}