<?php

namespace Raakkan\PhpTailwind\Tests\FlexGrid;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\GridColumnClass;

class GridColumnTest extends TestCase
{
    #[DataProvider('gridColumnClassProvider')]
    public function testGridColumnClass(string $input, string $expected): void
    {
        $gridColumnClass = GridColumnClass::parse($input);
        $this->assertInstanceOf(GridColumnClass::class, $gridColumnClass);
        $this->assertSame($expected, $gridColumnClass->toCss());
    }

    public static function gridColumnClassProvider(): array
    {
        return [
            // Standard values
            ['grid-cols-1', '.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr));}'],
            ['grid-cols-2', '.grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr));}'],
            ['grid-cols-3', '.grid-cols-3{grid-template-columns:repeat(3,minmax(0,1fr));}'],
            ['grid-cols-4', '.grid-cols-4{grid-template-columns:repeat(4,minmax(0,1fr));}'],
            ['grid-cols-5', '.grid-cols-5{grid-template-columns:repeat(5,minmax(0,1fr));}'],
            ['grid-cols-6', '.grid-cols-6{grid-template-columns:repeat(6,minmax(0,1fr));}'],
            ['grid-cols-7', '.grid-cols-7{grid-template-columns:repeat(7,minmax(0,1fr));}'],
            ['grid-cols-8', '.grid-cols-8{grid-template-columns:repeat(8,minmax(0,1fr));}'],
            ['grid-cols-9', '.grid-cols-9{grid-template-columns:repeat(9,minmax(0,1fr));}'],
            ['grid-cols-10', '.grid-cols-10{grid-template-columns:repeat(10,minmax(0,1fr));}'],
            ['grid-cols-11', '.grid-cols-11{grid-template-columns:repeat(11,minmax(0,1fr));}'],
            ['grid-cols-12', '.grid-cols-12{grid-template-columns:repeat(12,minmax(0,1fr));}'],

            // Special values
            ['grid-cols-none', '.grid-cols-none{grid-template-columns:none;}'],
            ['grid-cols-subgrid', '.grid-cols-subgrid{grid-template-columns:subgrid;}'],

            // Arbitrary values
            ['grid-cols-[13]', '.grid-cols-\[13\]{grid-template-columns:13;}'],
            ['grid-cols-[200px]', '.grid-cols-\[200px\]{grid-template-columns:200px;}'],
            ['grid-cols-[repeat(2,_1fr_2fr)]', '.grid-cols-\[repeat\(2\2c _1fr_2fr\)\]{grid-template-columns:repeat(2, 1fr 2fr);}'],
            ['grid-cols-[200px_minmax(900px,_1fr)_100px]', '.grid-cols-\[200px_minmax\(900px\2c _1fr\)_100px\]{grid-template-columns:200px minmax(900px, 1fr) 100px;}'],
            ['grid-cols-[1fr_500px_2fr]', '.grid-cols-\[1fr_500px_2fr\]{grid-template-columns:1fr 500px 2fr;}'],
        ];
    }

    public function testInvalidGridColumnClass(): void
    {
        $this->assertNull(GridColumnClass::parse('invalid-class'));
    }

    public function testGridColumnClassWithInvalidValue(): void
    {
        $gridColumnClass = GridColumnClass::parse('grid-cols-invalid');
        $this->assertInstanceOf(GridColumnClass::class, $gridColumnClass);
        $this->assertSame('', $gridColumnClass->toCss());
    }

    #[DataProvider('invalidArbitraryValuesProvider')]
    public function testInvalidArbitraryValues(string $input): void
    {
        $gridColumnClass = GridColumnClass::parse($input);
        $this->assertInstanceOf(GridColumnClass::class, $gridColumnClass);
        $this->assertSame('', $gridColumnClass->toCss());
    }

    public static function invalidArbitraryValuesProvider(): array
    {
        return [
            ['grid-cols-[]'],
        ];
    }
}
