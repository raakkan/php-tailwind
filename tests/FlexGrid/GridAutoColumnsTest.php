<?php

namespace Raakkan\PhpTailwind\Tests\FlexGrid;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\GridAutoColumnsClass;

class GridAutoColumnsTest extends TestCase
{
    #[DataProvider('gridAutoColumnsClassProvider')]
    public function testGridAutoColumnsClass(string $input, string $expected): void
    {
        $gridAutoColumnsClass = GridAutoColumnsClass::parse($input);
        $this->assertInstanceOf(GridAutoColumnsClass::class, $gridAutoColumnsClass);
        $this->assertSame($expected, $gridAutoColumnsClass->toCss());
    }

    public static function gridAutoColumnsClassProvider(): array
    {
        return [
            // Standard values
            ['auto-cols-auto', '.auto-cols-auto{grid-auto-columns:auto;}'],
            ['auto-cols-min', '.auto-cols-min{grid-auto-columns:min-content;}'],
            ['auto-cols-max', '.auto-cols-max{grid-auto-columns:max-content;}'],
            ['auto-cols-fr', '.auto-cols-fr{grid-auto-columns:minmax(0, 1fr);}'],
            
            // Arbitrary values
            ['auto-cols-[200px]', '.auto-cols-\[200px\]{grid-auto-columns:200px;}'],
            ['auto-cols-[2fr]', '.auto-cols-\[2fr\]{grid-auto-columns:2fr;}'],
            ['auto-cols-[minmax(0,_2fr)]', '.auto-cols-\[minmax\(0\2c _2fr\)\]{grid-auto-columns:minmax(0, 2fr);}'],
            ['auto-cols-[10%]', '.auto-cols-\[10\%\]{grid-auto-columns:10%;}'],
            ['auto-cols-[repeat(3,_minmax(0,_1fr))]', '.auto-cols-\[repeat\(3\2c _minmax\(0\2c _1fr\)\)\]{grid-auto-columns:repeat(3, minmax(0, 1fr));}'],
            ['auto-cols-[fit-content(200px)]', '.auto-cols-\[fit-content\(200px\)\]{grid-auto-columns:fit-content(200px);}'],
        ];
    }

    public function testInvalidGridAutoColumnsClass(): void
    {
        $this->assertNull(GridAutoColumnsClass::parse('invalid-class'));
    }

    public function testGridAutoColumnsClassWithInvalidValue(): void
    {
        $gridAutoColumnsClass = GridAutoColumnsClass::parse('auto-cols-invalid');
        $this->assertInstanceOf(GridAutoColumnsClass::class, $gridAutoColumnsClass);
        $this->assertSame('', $gridAutoColumnsClass->toCss());
    }

    #[DataProvider('invalidArbitraryValuesProvider')]
    public function testInvalidArbitraryValues(string $input): void
    {
        $gridAutoColumnsClass = GridAutoColumnsClass::parse($input);
        $this->assertInstanceOf(GridAutoColumnsClass::class, $gridAutoColumnsClass);
        $this->assertSame('', $gridAutoColumnsClass->toCss());
    }

    public static function invalidArbitraryValuesProvider(): array
    {
        return [
            ['auto-cols-[]'],
            ['auto-cols-[  ]'],
            ['auto-cols-[invalid]'],
            ['auto-cols-[200]'], // Missing unit
            ['auto-cols-[2fr 3fr]'], // Space without underscore
        ];
    }

    public function testEdgeCases(): void
    {
        // Test with very large numbers
        $largeNumber = str_repeat('9', 100);
        $gridAutoColumnsClass = GridAutoColumnsClass::parse("auto-cols-[{$largeNumber}px]");
        $this->assertInstanceOf(GridAutoColumnsClass::class, $gridAutoColumnsClass);
        $this->assertNotEmpty($gridAutoColumnsClass->toCss());

        // Test with special characters
        $specialChars = "auto-cols-[calc(100%_-_20px)]";
        $gridAutoColumnsClass = GridAutoColumnsClass::parse($specialChars);
        $this->assertInstanceOf(GridAutoColumnsClass::class, $gridAutoColumnsClass);
        $this->assertNotEmpty($gridAutoColumnsClass->toCss());

        // Test with complex minmax expression
        $complexMinmax = "auto-cols-[minmax(max(50px,_20%),_1fr)]";
        $gridAutoColumnsClass = GridAutoColumnsClass::parse($complexMinmax);
        $this->assertInstanceOf(GridAutoColumnsClass::class, $gridAutoColumnsClass);
        $this->assertNotEmpty($gridAutoColumnsClass->toCss());
    }

    // public function testCaseInsensitivity(): void
    // {
    //     $lowerCase = GridAutoColumnsClass::parse('auto-cols-auto');
    //     $upperCase = GridAutoColumnsClass::parse('AUTO-COLS-AUTO');
    //     $mixedCase = GridAutoColumnsClass::parse('AuTo-CoLs-AuTo');

    //     $this->assertSame($lowerCase->toCss(), $upperCase->toCss());
    //     $this->assertSame($lowerCase->toCss(), $mixedCase->toCss());
    // }

    // public function testArbitraryValueWithSpaces(): void
    // {
    //     $withSpaces = GridAutoColumnsClass::parse('auto-cols-[repeat(2,_minmax(0,_1fr))]');
    //     $withoutSpaces = GridAutoColumnsClass::parse('auto-cols-[repeat(2,minmax(0,1fr))]');

    //     $this->assertSame($withSpaces->toCss(), $withoutSpaces->toCss());
    // }
}