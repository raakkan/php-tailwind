<?php

namespace Raakkan\PhpTailwind\Tests\FlexGrid;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\GridAutoRowsClass;

class GridAutoRowsTest extends TestCase
{
    #[DataProvider('gridAutoRowsClassProvider')]
    public function test_grid_auto_rows_class(string $input, string $expected): void
    {
        $gridAutoRowsClass = GridAutoRowsClass::parse($input);
        $this->assertInstanceOf(GridAutoRowsClass::class, $gridAutoRowsClass);
        $this->assertSame($expected, $gridAutoRowsClass->toCss());
    }

    public static function gridAutoRowsClassProvider(): array
    {
        return [
            // Standard values
            ['auto-rows-auto', '.auto-rows-auto{grid-auto-rows:auto;}'],
            ['auto-rows-min', '.auto-rows-min{grid-auto-rows:min-content;}'],
            ['auto-rows-max', '.auto-rows-max{grid-auto-rows:max-content;}'],
            ['auto-rows-fr', '.auto-rows-fr{grid-auto-rows:minmax(0, 1fr);}'],

            // Arbitrary values
            ['auto-rows-[200px]', '.auto-rows-\[200px\]{grid-auto-rows:200px;}'],
            ['auto-rows-[2fr]', '.auto-rows-\[2fr\]{grid-auto-rows:2fr;}'],
            ['auto-rows-[minmax(0,_2fr)]', '.auto-rows-\[minmax\(0\2c _2fr\)\]{grid-auto-rows:minmax(0, 2fr);}'],
            ['auto-rows-[10%]', '.auto-rows-\[10\%\]{grid-auto-rows:10%;}'],
            ['auto-rows-[repeat(3,_minmax(0,_1fr))]', '.auto-rows-\[repeat\(3\2c _minmax\(0\2c _1fr\)\)\]{grid-auto-rows:repeat(3, minmax(0, 1fr));}'],
            ['auto-rows-[fit-content(200px)]', '.auto-rows-\[fit-content\(200px\)\]{grid-auto-rows:fit-content(200px);}'],
        ];
    }

    public function test_invalid_grid_auto_rows_class(): void
    {
        $this->assertNull(GridAutoRowsClass::parse('invalid-class'));
    }

    public function test_grid_auto_rows_class_with_invalid_value(): void
    {
        $gridAutoRowsClass = GridAutoRowsClass::parse('auto-rows-invalid');
        $this->assertInstanceOf(GridAutoRowsClass::class, $gridAutoRowsClass);
        $this->assertSame('', $gridAutoRowsClass->toCss());
    }

    #[DataProvider('invalidArbitraryValuesProvider')]
    public function test_invalid_arbitrary_values(string $input): void
    {
        $gridAutoRowsClass = GridAutoRowsClass::parse($input);
        $this->assertInstanceOf(GridAutoRowsClass::class, $gridAutoRowsClass);
        $this->assertSame('', $gridAutoRowsClass->toCss());
    }

    public static function invalidArbitraryValuesProvider(): array
    {
        return [
            ['auto-rows-[]'],
            ['auto-rows-[  ]'],
            ['auto-rows-[invalid]'],
            ['auto-rows-[200]'], // Missing unit
            ['auto-rows-[2fr 3fr]'], // Space without underscore
        ];
    }

    public function test_edge_cases(): void
    {
        // Test with very large numbers
        $largeNumber = str_repeat('9', 100);
        $gridAutoRowsClass = GridAutoRowsClass::parse("auto-rows-[{$largeNumber}px]");
        $this->assertInstanceOf(GridAutoRowsClass::class, $gridAutoRowsClass);
        $this->assertNotEmpty($gridAutoRowsClass->toCss());

        // Test with special characters
        $specialChars = 'auto-rows-[calc(100%_-_20px)]';
        $gridAutoRowsClass = GridAutoRowsClass::parse($specialChars);
        $this->assertInstanceOf(GridAutoRowsClass::class, $gridAutoRowsClass);
        $this->assertNotEmpty($gridAutoRowsClass->toCss());

        // Test with complex minmax expression
        $complexMinmax = 'auto-rows-[minmax(max(50px,_20%),_1fr)]';
        $gridAutoRowsClass = GridAutoRowsClass::parse($complexMinmax);
        $this->assertInstanceOf(GridAutoRowsClass::class, $gridAutoRowsClass);
        $this->assertNotEmpty($gridAutoRowsClass->toCss());
    }

    // public function testCaseInsensitivity(): void
    // {
    //     $lowerCase = GridAutoRowsClass::parse('auto-rows-auto');
    //     $upperCase = GridAutoRowsClass::parse('AUTO-ROWS-AUTO');
    //     $mixedCase = GridAutoRowsClass::parse('AuTo-RoWs-AuTo');

    //     $this->assertSame($lowerCase->toCss(), $upperCase->toCss());
    //     $this->assertSame($lowerCase->toCss(), $mixedCase->toCss());
    // }

    // public function testArbitraryValueWithSpaces(): void
    // {
    //     $withSpaces = GridAutoRowsClass::parse('auto-rows-[repeat(2,_minmax(0,_1fr))]');
    //     $withoutSpaces = GridAutoRowsClass::parse('auto-rows-[repeat(2,minmax(0,1fr))]');

    //     $this->assertSame($withSpaces->toCss(), $withoutSpaces->toCss());
    // }
}
