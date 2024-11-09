<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\OutlineWidthClass;

class OutlineWidthTest extends TestCase
{
    #[DataProvider('outlineWidthClassProvider')]
    public function testOutlineWidthClass(string $input, string $expected): void
    {
        $outlineWidthClass = OutlineWidthClass::parse($input);
        $this->assertInstanceOf(OutlineWidthClass::class, $outlineWidthClass);
        $this->assertSame($expected, $outlineWidthClass->toCss());
    }

    public static function outlineWidthClassProvider(): array
    {
        return [
            ['outline-0', '.outline-0{outline-width:0px;}'],
            ['outline-1', '.outline-1{outline-width:1px;}'],
            ['outline-2', '.outline-2{outline-width:2px;}'],
            ['outline-4', '.outline-4{outline-width:4px;}'],
            ['outline-8', '.outline-8{outline-width:8px;}'],
        ];
    }

    #[DataProvider('arbitraryOutlineWidthClassProvider')]
    public function testArbitraryOutlineWidthClass(string $input, string $expected): void
    {
        $outlineWidthClass = OutlineWidthClass::parse($input);
        $this->assertInstanceOf(OutlineWidthClass::class, $outlineWidthClass);
        $this->assertSame($expected, $outlineWidthClass->toCss());
    }

    public static function arbitraryOutlineWidthClassProvider(): array
    {
        return [
            ['outline-[3px]', '.outline-\\[3px\\]{outline-width:3px;}'],
            ['outline-[0.5em]', '.outline-\\[0\\.5em\\]{outline-width:0.5em;}'],
            ['outline-[3rem]', '.outline-\\[3rem\\]{outline-width:3rem;}'],
            ['outline-[5%]', '.outline-\\[5\\%\\]{outline-width:5%;}'],
            ['outline-[calc(1px+2px)]', '.outline-\\[calc\\(1px\\+2px\\)\\]{outline-width:calc(1px+2px);}'],
            // ['outline-[length:var(--outline-width)]', ".outline-\\[length\\:var\\(--outline-width\\)\\]{outline-width:length:var(--outline-width);}"],
        ];
    }

    public function testInvalidOutlineWidthClass(): void
    {
        $this->assertNull(OutlineWidthClass::parse('invalid-class'));
    }

    #[DataProvider('invalidOutlineWidthValueProvider')]
    public function testOutlineWidthClassWithInvalidValue(string $input): void
    {
        $outlineWidthClass = OutlineWidthClass::parse($input);
        $this->assertInstanceOf(OutlineWidthClass::class, $outlineWidthClass);
        $this->assertSame('', $outlineWidthClass->toCss());
    }

    public static function invalidOutlineWidthValueProvider(): array
    {
        return [
            ['outline-3'],
            ['outline-5'],
            ['outline-6'],
            ['outline-7'],
            ['outline-9'],
            ['outline-10'],
            ['outline-DEFAULT'],
        ];
    }

    #[DataProvider('invalidArbitraryOutlineWidthClassProvider')]
    public function testInvalidArbitraryOutlineWidthClass(string $input): void
    {
        $outlineWidthClass = OutlineWidthClass::parse($input);
        $this->assertInstanceOf(OutlineWidthClass::class, $outlineWidthClass);
        $this->assertSame('', $outlineWidthClass->toCss());
    }

    public static function invalidArbitraryOutlineWidthClassProvider(): array
    {
        return [
            ['outline-[invalid]'],
            ['outline-[10]'],
            ['outline-[em]'],
            ['outline-[]'],
            ['outline-[10px'],
            ['outline-10px]'],
        ];
    }
}
