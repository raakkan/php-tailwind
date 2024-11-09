<?php

namespace Raakkan\PhpTailwind\Tests\FlexGrid;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\GridRowClass;

class GridRowTest extends TestCase
{
    #[DataProvider('gridRowClassProvider')]
    public function testGridRowClass(string $input, string $expected): void
    {
        $gridRowClass = GridRowClass::parse($input);
        $this->assertInstanceOf(GridRowClass::class, $gridRowClass);
        $this->assertSame($expected, $gridRowClass->toCss());
    }

    public static function gridRowClassProvider(): array
    {
        return [
            // Standard values
            ['grid-rows-1', '.grid-rows-1{grid-template-rows:repeat(1,minmax(0,1fr));}'],
            ['grid-rows-2', '.grid-rows-2{grid-template-rows:repeat(2,minmax(0,1fr));}'],
            ['grid-rows-3', '.grid-rows-3{grid-template-rows:repeat(3,minmax(0,1fr));}'],
            ['grid-rows-4', '.grid-rows-4{grid-template-rows:repeat(4,minmax(0,1fr));}'],
            ['grid-rows-5', '.grid-rows-5{grid-template-rows:repeat(5,minmax(0,1fr));}'],
            ['grid-rows-6', '.grid-rows-6{grid-template-rows:repeat(6,minmax(0,1fr));}'],
            ['grid-rows-7', '.grid-rows-7{grid-template-rows:repeat(7,minmax(0,1fr));}'],
            ['grid-rows-8', '.grid-rows-8{grid-template-rows:repeat(8,minmax(0,1fr));}'],
            ['grid-rows-9', '.grid-rows-9{grid-template-rows:repeat(9,minmax(0,1fr));}'],
            ['grid-rows-10', '.grid-rows-10{grid-template-rows:repeat(10,minmax(0,1fr));}'],
            ['grid-rows-11', '.grid-rows-11{grid-template-rows:repeat(11,minmax(0,1fr));}'],
            ['grid-rows-12', '.grid-rows-12{grid-template-rows:repeat(12,minmax(0,1fr));}'],

            // Special values
            ['grid-rows-none', '.grid-rows-none{grid-template-rows:none;}'],
            ['grid-rows-subgrid', '.grid-rows-subgrid{grid-template-rows:subgrid;}'],

            // Arbitrary values
            ['grid-rows-[13]', '.grid-rows-\[13\]{grid-template-rows:13;}'],
            ['grid-rows-[200px]', '.grid-rows-\[200px\]{grid-template-rows:200px;}'],
            ['grid-rows-[repeat(2,_1fr_2fr)]', '.grid-rows-\[repeat\(2\2c _1fr_2fr\)\]{grid-template-rows:repeat(2, 1fr 2fr);}'],
            ['grid-rows-[200px_minmax(900px,_1fr)_100px]', '.grid-rows-\[200px_minmax\(900px\2c _1fr\)_100px\]{grid-template-rows:200px minmax(900px, 1fr) 100px;}'],
            ['grid-rows-[1fr_500px_2fr]', '.grid-rows-\[1fr_500px_2fr\]{grid-template-rows:1fr 500px 2fr;}'],
        ];
    }

    public function testInvalidGridRowClass(): void
    {
        $this->assertNull(GridRowClass::parse('invalid-class'));
    }

    public function testGridRowClassWithInvalidValue(): void
    {
        $gridRowClass = GridRowClass::parse('grid-rows-invalid');
        $this->assertInstanceOf(GridRowClass::class, $gridRowClass);
        $this->assertSame('', $gridRowClass->toCss());
    }

    #[DataProvider('invalidArbitraryValuesProvider')]
    public function testInvalidArbitraryValues(string $input): void
    {
        $gridRowClass = GridRowClass::parse($input);
        $this->assertInstanceOf(GridRowClass::class, $gridRowClass);
        $this->assertSame('', $gridRowClass->toCss());
    }

    public static function invalidArbitraryValuesProvider(): array
    {
        return [
            ['grid-rows-[]'],
            ['grid-rows-[  ]'],
            // ['grid-rows-[invalid value]'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test with very large numbers
        $largeNumber = str_repeat('9', 100);
        $gridRowClass = GridRowClass::parse("grid-rows-[$largeNumber]");
        $this->assertInstanceOf(GridRowClass::class, $gridRowClass);
        $this->assertNotEmpty($gridRowClass->toCss());

        // Test with special characters
        $specialChars = 'grid-rows-[!@#$%^&*()]';
        $gridRowClass = GridRowClass::parse($specialChars);
        $this->assertInstanceOf(GridRowClass::class, $gridRowClass);
        $this->assertEmpty($gridRowClass->toCss());

        // Test with empty arbitrary value
        $emptyArbitrary = 'grid-rows-[]';
        $gridRowClass = GridRowClass::parse($emptyArbitrary);
        $this->assertInstanceOf(GridRowClass::class, $gridRowClass);
        $this->assertEmpty($gridRowClass->toCss());
    }
}
