<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\RingOffsetWidthClass;
use PHPUnit\Framework\Attributes\DataProvider;

class RingOffsetWidthTest extends TestCase
{
    #[DataProvider('ringOffsetWidthClassProvider')]
    public function testRingOffsetWidthClass(string $input, string $expected): void
    {
        $ringOffsetWidthClass = RingOffsetWidthClass::parse($input);
        $this->assertInstanceOf(RingOffsetWidthClass::class, $ringOffsetWidthClass);
        $this->assertSame($expected, $ringOffsetWidthClass->toCss());
    }

    public static function ringOffsetWidthClassProvider(): array
    {
        return [
            ['ring-offset-0', ".ring-offset-0{--tw-ring-offset-width:0px;}"],
            ['ring-offset-1', ".ring-offset-1{--tw-ring-offset-width:1px;}"],
            ['ring-offset-2', ".ring-offset-2{--tw-ring-offset-width:2px;}"],
            ['ring-offset-4', ".ring-offset-4{--tw-ring-offset-width:4px;}"],
            ['ring-offset-8', ".ring-offset-8{--tw-ring-offset-width:8px;}"],
        ];
    }

    #[DataProvider('arbitraryRingOffsetWidthClassProvider')]
    public function testArbitraryRingOffsetWidthClass(string $input, string $expected): void
    {
        $ringOffsetWidthClass = RingOffsetWidthClass::parse($input);
        $this->assertInstanceOf(RingOffsetWidthClass::class, $ringOffsetWidthClass);
        $this->assertSame($expected, $ringOffsetWidthClass->toCss());
    }

    public static function arbitraryRingOffsetWidthClassProvider(): array
    {
        return [
            ['ring-offset-[3px]', ".ring-offset-\\[3px\\]{--tw-ring-offset-width:3px;}"],
            ['ring-offset-[0.5em]', ".ring-offset-\\[0\\.5em\\]{--tw-ring-offset-width:0.5em;}"],
            ['ring-offset-[-2px]', ".ring-offset-\\[-2px\\]{--tw-ring-offset-width:-2px;}"],
            ['ring-offset-[5%]', ".ring-offset-\\[5\\%\\]{--tw-ring-offset-width:5%;}"],
            ['ring-offset-[2rem]', ".ring-offset-\\[2rem\\]{--tw-ring-offset-width:2rem;}"],
            ['ring-offset-[calc(1px+2px)]', ".ring-offset-\\[calc\\(1px\\+2px\\)\\]{--tw-ring-offset-width:calc(1px+2px);}"],
            // ['ring-offset-[clamp(1px,2px,3px)]', ".ring-offset-\\[clamp\\(1px\\,2px\\,3px\\)\\]{--tw-ring-offset-width:clamp(1px,2px,3px);}"],
            // ['ring-offset-[var(--offset)]', ".ring-offset-\\[var\\(--offset\\)\\]{--tw-ring-offset-width:var(--offset);}"],
        ];
    }

    public function testInvalidRingOffsetWidthClass(): void
    {
        $this->assertNull(RingOffsetWidthClass::parse('invalid-class'));
    }

    #[DataProvider('invalidRingOffsetWidthValueProvider')]
    public function testRingOffsetWidthClassWithInvalidValue(string $input): void
    {
        $ringOffsetWidthClass = RingOffsetWidthClass::parse($input);
        $this->assertInstanceOf(RingOffsetWidthClass::class, $ringOffsetWidthClass);
        $this->assertSame('', $ringOffsetWidthClass->toCss());
    }

    public static function invalidRingOffsetWidthValueProvider(): array
    {
        return [
            ['ring-offset-3'],
            ['ring-offset-5'],
            ['ring-offset-6'],
            ['ring-offset-7'],
            ['ring-offset-9'],
            ['ring-offset-10'],
            ['ring-offset-DEFAULT'],
        ];
    }

    #[DataProvider('invalidArbitraryRingOffsetWidthClassProvider')]
    public function testInvalidArbitraryRingOffsetWidthClass(string $input): void
    {
        $ringOffsetWidthClass = RingOffsetWidthClass::parse($input);
        $this->assertInstanceOf(RingOffsetWidthClass::class, $ringOffsetWidthClass);
        $this->assertSame('', $ringOffsetWidthClass->toCss());
    }

    public static function invalidArbitraryRingOffsetWidthClassProvider(): array
    {
        return [
            ['ring-offset-[invalid]'],
            ['ring-offset-[10]'],
            ['ring-offset-[em]'],
            ['ring-offset-[]'],
            ['ring-offset-[10px'],
            ['ring-offset-10px]'],
        ];
    }
}