<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Layout\ColumnsClass;
use PHPUnit\Framework\Attributes\DataProvider;

class ColumnsClassTest extends TestCase
{
    #[DataProvider('columnsClassProvider')]
    public function testColumnsClass(string $input, string $expected): void
    {
        $columnsClass = ColumnsClass::parse($input);
        $this->assertInstanceOf(ColumnsClass::class, $columnsClass);
        $this->assertSame($expected, $columnsClass->toCss());
    }

    public static function columnsClassProvider(): array
    {
        return [
            ['columns-1', '.columns-1{columns:1;}'],
            ['columns-2', '.columns-2{columns:2;}'],
            ['columns-3', '.columns-3{columns:3;}'],
            ['columns-4', '.columns-4{columns:4;}'],
            ['columns-5', '.columns-5{columns:5;}'],
            ['columns-6', '.columns-6{columns:6;}'],
            ['columns-7', '.columns-7{columns:7;}'],
            ['columns-8', '.columns-8{columns:8;}'],
            ['columns-9', '.columns-9{columns:9;}'],
            ['columns-10', '.columns-10{columns:10;}'],
            ['columns-11', '.columns-11{columns:11;}'],
            ['columns-12', '.columns-12{columns:12;}'],
            ['columns-auto', '.columns-auto{columns:auto;}'],
            ['columns-3xs', '.columns-3xs{columns:16rem;}'],
            ['columns-2xs', '.columns-2xs{columns:18rem;}'],
            ['columns-xs', '.columns-xs{columns:20rem;}'],
            ['columns-sm', '.columns-sm{columns:24rem;}'],
            ['columns-md', '.columns-md{columns:28rem;}'],
            ['columns-lg', '.columns-lg{columns:32rem;}'],
            ['columns-xl', '.columns-xl{columns:36rem;}'],
            ['columns-2xl', '.columns-2xl{columns:42rem;}'],
            ['columns-3xl', '.columns-3xl{columns:48rem;}'],
            ['columns-4xl', '.columns-4xl{columns:56rem;}'],
            ['columns-5xl', '.columns-5xl{columns:64rem;}'],
            ['columns-6xl', '.columns-6xl{columns:72rem;}'],
            ['columns-7xl', '.columns-7xl{columns:80rem;}'],
            ['columns-[13]', '.columns-\[13\]{columns:13;}'],
            ['columns-[2.5rem]', '.columns-\[2\.5rem\]{columns:2.5rem;}'],
        ];
    }

    public function testInvalidColumnsClass(): void
    {
        $this->assertNull(ColumnsClass::parse('columns-invalid'));
    }

    public function testColumnsClassWithInvalidValue(): void
    {
        $columnsClass = new ColumnsClass('invalid');
        $this->assertSame('', $columnsClass->toCss());
    }

    public function testArbitraryColumnsValidation(): void
    {
        $this->assertInstanceOf(ColumnsClass::class, ColumnsClass::parse('columns-[15]'));
        $this->assertInstanceOf(ColumnsClass::class, ColumnsClass::parse('columns-[3.5rem]'));
    }
}