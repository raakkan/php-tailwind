<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\GapClass;
use PHPUnit\Framework\Attributes\DataProvider;

class GapClassTest extends TestCase
{
    #[DataProvider('gapClassProvider')]
    public function testGapClass(string $input, string $expected): void
    {
        $gapClass = GapClass::parse($input);
        $this->assertInstanceOf(GapClass::class, $gapClass);
        $this->assertSame($expected, $gapClass->toCss());
    }

    public static function gapClassProvider(): array
    {
        return [
            // Standard values
            ['gap-0', '.gap-0{gap:0px;}'],
            ['gap-px', '.gap-px{gap:1px;}'],
            ['gap-0.5', '.gap-0\.5{gap:0.125rem;}'],
            ['gap-1', '.gap-1{gap:0.25rem;}'],
            ['gap-1.5', '.gap-1\.5{gap:0.375rem;}'],
            ['gap-2', '.gap-2{gap:0.5rem;}'],
            ['gap-2.5', '.gap-2\.5{gap:0.625rem;}'],
            ['gap-3', '.gap-3{gap:0.75rem;}'],
            ['gap-3.5', '.gap-3\.5{gap:0.875rem;}'],
            ['gap-4', '.gap-4{gap:1rem;}'],
            ['gap-5', '.gap-5{gap:1.25rem;}'],
            ['gap-6', '.gap-6{gap:1.5rem;}'],
            ['gap-8', '.gap-8{gap:2rem;}'],
            ['gap-10', '.gap-10{gap:2.5rem;}'],
            ['gap-12', '.gap-12{gap:3rem;}'],
            ['gap-16', '.gap-16{gap:4rem;}'],
            ['gap-20', '.gap-20{gap:5rem;}'],
            ['gap-24', '.gap-24{gap:6rem;}'],
            ['gap-32', '.gap-32{gap:8rem;}'],
            ['gap-40', '.gap-40{gap:10rem;}'],
            ['gap-48', '.gap-48{gap:12rem;}'],
            ['gap-56', '.gap-56{gap:14rem;}'],
            ['gap-64', '.gap-64{gap:16rem;}'],
            ['gap-72', '.gap-72{gap:18rem;}'],
            ['gap-80', '.gap-80{gap:20rem;}'],
            ['gap-96', '.gap-96{gap:24rem;}'],
            
            // X-axis
            ['gap-x-4', '.gap-x-4{column-gap:1rem;}'],
            ['gap-x-8', '.gap-x-8{column-gap:2rem;}'],
            ['gap-x-px', '.gap-x-px{column-gap:1px;}'],
            
            // Y-axis
            ['gap-y-4', '.gap-y-4{row-gap:1rem;}'],
            ['gap-y-8', '.gap-y-8{row-gap:2rem;}'],
            ['gap-y-0.5', '.gap-y-0\.5{row-gap:0.125rem;}'],
            
            // Arbitrary values
            ['gap-[14px]', '.gap-\[14px\]{gap:14px;}'],
            ['gap-[3.23rem]', '.gap-\[3\.23rem\]{gap:3.23rem;}'],
            ['gap-[60%]', '.gap-\[60\%\]{gap:60%;}'],
            ['gap-x-[14px]', '.gap-x-\[14px\]{column-gap:14px;}'],
            ['gap-y-[3.23rem]', '.gap-y-\[3\.23rem\]{row-gap:3.23rem;}'],
            
            // Calc values
            ['gap-[calc(100%-14px)]', '.gap-\[calc\(100\%-14px\)\]{gap:calc(100%-14px);}'],
            ['gap-x-[calc(1rem+8px)]', '.gap-x-\[calc\(1rem\+8px\)\]{column-gap:calc(1rem+8px);}'],
            ['gap-y-[calc(50vh-20px)]', '.gap-y-\[calc\(50vh-20px\)\]{row-gap:calc(50vh-20px);}'],
        ];
    }

    public function testInvalidGapClass(): void
    {
        $this->assertNull(GapClass::parse('invalid-class'));
    }

    public function testGapClassWithInvalidValue(): void
    {
        $gapClass = GapClass::parse('gap-invalid');
        $this->assertInstanceOf(GapClass::class, $gapClass);
        $this->assertSame('', $gapClass->toCss());
    }

    #[DataProvider('invalidArbitraryValuesProvider')]
    public function testInvalidArbitraryValues(string $input): void
    {
        $gapClass = GapClass::parse($input);
        $this->assertInstanceOf(GapClass::class, $gapClass);
        $this->assertSame('', $gapClass->toCss());
    }

    public static function invalidArbitraryValuesProvider(): array
    {
        return [
            ['gap-[invalid]'],
            ['gap-[10]'],
            ['gap-[10px10px]'],
            ['gap-[calc(100%14px)]'],
            ['gap-[calc(100% 14px)]'],
        ];
    }

    #[DataProvider('validCalcValuesProvider')]
    public function testValidCalcValues(string $input, string $expected): void
    {
        $gapClass = GapClass::parse($input);
        $this->assertInstanceOf(GapClass::class, $gapClass);
        $this->assertSame($expected, $gapClass->toCss());
    }

    public static function validCalcValuesProvider(): array
    {
        return [
            ['gap-[calc(100%+14px)]', '.gap-\[calc\(100\%\+14px\)\]{gap:calc(100%+14px);}'],
            ['gap-[calc(50vh-20px)]', '.gap-\[calc\(50vh-20px\)\]{gap:calc(50vh-20px);}'],
            ['gap-[calc(100vw/2)]', '.gap-\[calc\(100vw\/2\)\]{gap:calc(100vw/2);}'],
            ['gap-[calc((100%+14px)/2)]', '.gap-\[calc\(\(100\%\+14px\)\/2\)\]{gap:calc((100%+14px)/2);}'],
        ];
    }
}