<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\OutlineOffsetClass;

class OutlineOffsetTest extends TestCase
{
    #[DataProvider('outlineOffsetClassProvider')]
    public function testOutlineOffsetClass(string $input, string $expected): void
    {
        $outlineOffsetClass = OutlineOffsetClass::parse($input);
        $this->assertInstanceOf(OutlineOffsetClass::class, $outlineOffsetClass);
        $this->assertSame($expected, $outlineOffsetClass->toCss());
    }

    public static function outlineOffsetClassProvider(): array
    {
        return [
            ['outline-offset-0', '.outline-offset-0{outline-offset:0px;}'],
            ['outline-offset-1', '.outline-offset-1{outline-offset:1px;}'],
            ['outline-offset-2', '.outline-offset-2{outline-offset:2px;}'],
            ['outline-offset-4', '.outline-offset-4{outline-offset:4px;}'],
            ['outline-offset-8', '.outline-offset-8{outline-offset:8px;}'],
        ];
    }

    #[DataProvider('arbitraryOutlineOffsetClassProvider')]
    public function testArbitraryOutlineOffsetClass(string $input, string $expected): void
    {
        $outlineOffsetClass = OutlineOffsetClass::parse($input);
        $this->assertInstanceOf(OutlineOffsetClass::class, $outlineOffsetClass);
        $this->assertSame($expected, $outlineOffsetClass->toCss());
    }

    public static function arbitraryOutlineOffsetClassProvider(): array
    {
        return [
            ['outline-offset-[3px]', '.outline-offset-\\[3px\\]{outline-offset:3px;}'],
            ['outline-offset-[0.5em]', '.outline-offset-\\[0\\.5em\\]{outline-offset:0.5em;}'],
            ['outline-offset-[-2px]', '.outline-offset-\\[-2px\\]{outline-offset:-2px;}'],
            ['outline-offset-[5%]', '.outline-offset-\\[5\\%\\]{outline-offset:5%;}'],
            ['outline-offset-[2rem]', '.outline-offset-\\[2rem\\]{outline-offset:2rem;}'],
            ['outline-offset-[calc(1px+2px)]', '.outline-offset-\\[calc\\(1px\\+2px\\)\\]{outline-offset:calc(1px+2px);}'],
            // ['outline-offset-[clamp(1px,2px,3px)]', ".outline-offset-\\[clamp\\(1px\\,2px\\,3px\\)\\]{outline-offset:clamp(1px,2px,3px);}"],
            // ['outline-offset-[var(--offset)]', ".outline-offset-\\[var\\(--offset\\)\\]{outline-offset:var(--offset);}"],
        ];
    }

    public function testInvalidOutlineOffsetClass(): void
    {
        $this->assertNull(OutlineOffsetClass::parse('invalid-class'));
    }

    #[DataProvider('invalidOutlineOffsetValueProvider')]
    public function testOutlineOffsetClassWithInvalidValue(string $input): void
    {
        $outlineOffsetClass = OutlineOffsetClass::parse($input);
        $this->assertInstanceOf(OutlineOffsetClass::class, $outlineOffsetClass);
        $this->assertSame('', $outlineOffsetClass->toCss());
    }

    public static function invalidOutlineOffsetValueProvider(): array
    {
        return [
            ['outline-offset-3'],
            ['outline-offset-5'],
            ['outline-offset-6'],
            ['outline-offset-7'],
            ['outline-offset-9'],
            ['outline-offset-10'],
            ['outline-offset-DEFAULT'],
        ];
    }

    #[DataProvider('invalidArbitraryOutlineOffsetClassProvider')]
    public function testInvalidArbitraryOutlineOffsetClass(string $input): void
    {
        $outlineOffsetClass = OutlineOffsetClass::parse($input);
        $this->assertInstanceOf(OutlineOffsetClass::class, $outlineOffsetClass);
        $this->assertSame('', $outlineOffsetClass->toCss());
    }

    public static function invalidArbitraryOutlineOffsetClassProvider(): array
    {
        return [
            ['outline-offset-[invalid]'],
            ['outline-offset-[10]'],
            ['outline-offset-[em]'],
            ['outline-offset-[]'],
            ['outline-offset-[10px'],
            ['outline-offset-10px]'],
        ];
    }
}
