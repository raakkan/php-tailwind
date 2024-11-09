<?php

namespace Raakkan\PhpTailwind\Tests\FlexGrid;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\GridColumnUtilityClass;

class GridColumnUtilityClassTest extends TestCase
{
    #[DataProvider('gridColumnClassProvider')]
    public function testGridColumnUtilityClass(string $input, string $expected): void
    {
        $gridColumnClass = GridColumnUtilityClass::parse($input);
        $this->assertInstanceOf(GridColumnUtilityClass::class, $gridColumnClass);
        $this->assertSame($expected, $gridColumnClass->toCss());
    }

    public static function gridColumnClassProvider(): array
    {
        return [
            // Span classes
            ['col-span-1', '.col-span-1{grid-column:span 1 / span 1;}'],
            ['col-span-12', '.col-span-12{grid-column:span 12 / span 12;}'],
            ['col-span-full', '.col-span-full{grid-column:1 / -1;}'],

            // Start classes
            ['col-start-1', '.col-start-1{grid-column-start:1;}'],
            ['col-start-13', '.col-start-13{grid-column-start:13;}'],
            ['col-start-auto', '.col-start-auto{grid-column-start:auto;}'],

            // End classes
            ['col-end-1', '.col-end-1{grid-column-end:1;}'],
            ['col-end-13', '.col-end-13{grid-column-end:13;}'],
            ['col-end-auto', '.col-end-auto{grid-column-end:auto;}'],
            // Auto class
            ['col-auto', '.col-auto{grid-column:auto;}'],

            // Arbitrary value classes
            ['col-[1/3]', '.col-\[1\/3\]{grid-column:1/3;}'],
            ['col-[span_2/3]', '.col-\[span_2\/3\]{grid-column:span 2/3;}'],
            ['col-[7]', '.col-\[7\]{grid-column:7;}'],
            ['col-start-[4]', '.col-start-\[4\]{grid-column-start:4;}'],
            ['col-end-[7]', '.col-end-\[7\]{grid-column-end:7;}'],
        ];
    }

    public function testInvalidGridColumnClass(): void
    {
        $this->assertNull(GridColumnUtilityClass::parse('col-invalid'));
    }

    public function testGridColumnClassWithInvalidValue(): void
    {
        $gridColumnClass = new GridColumnUtilityClass('invalid');
        $this->assertSame('', $gridColumnClass->toCss());
    }

    // #[DataProvider('invalidArbitraryValuesProvider')]
    // public function testInvalidArbitraryValues(string $input): void
    // {
    //     $gridColumnClass = GridColumnUtilityClass::parse($input);
    //     $this->assertInstanceOf(GridColumnUtilityClass::class, $gridColumnClass);
    //     $this->assertSame('', $gridColumnClass->toCss());
    // }

    // public static function invalidArbitraryValuesProvider(): array
    // {
    //     return [
    //         ['col-[invalid value]'],
    //     ];
    // }

    #[DataProvider('outOfRangeValuesProvider')]
    public function testOutOfRangeValues(string $input): void
    {
        $gridColumnClass = GridColumnUtilityClass::parse($input);
        $this->assertInstanceOf(GridColumnUtilityClass::class, $gridColumnClass);
        $this->assertSame('', $gridColumnClass->toCss());
    }

    public static function outOfRangeValuesProvider(): array
    {
        return [
            ['col-span-0'],
            ['col-span-13'],
            ['col-start-0'],
            ['col-start-14'],
            ['col-end-0'],
            ['col-end-14'],
        ];
    }

    public function testArbitraryValueEscaping(): void
    {
        $input = 'col-[2,3]';
        $expected = '.col-\[2\2c 3\]{grid-column:2,3;}';
        $gridColumnClass = GridColumnUtilityClass::parse($input);
        $this->assertInstanceOf(GridColumnUtilityClass::class, $gridColumnClass);
        $this->assertSame($expected, $gridColumnClass->toCss());
    }
}
