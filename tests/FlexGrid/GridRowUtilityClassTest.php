<?php

namespace Raakkan\PhpTailwind\Tests\FlexGrid;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\GridRowUtilityClass;

class GridRowUtilityClassTest extends TestCase
{
    #[DataProvider('gridRowClassProvider')]
    public function test_grid_row_utility_class(string $input, string $expected): void
    {
        $gridRowClass = GridRowUtilityClass::parse($input);
        $this->assertInstanceOf(GridRowUtilityClass::class, $gridRowClass);
        $this->assertSame($expected, $gridRowClass->toCss());
    }

    public static function gridRowClassProvider(): array
    {
        return [
            // Span classes
            ['row-span-1', '.row-span-1{grid-row:span 1 / span 1;}'],
            ['row-span-6', '.row-span-6{grid-row:span 6 / span 6;}'],
            ['row-span-12', '.row-span-12{grid-row:span 12 / span 12;}'],
            ['row-span-full', '.row-span-full{grid-row:1 / -1;}'],

            // Start classes
            ['row-start-1', '.row-start-1{grid-row-start:1;}'],
            ['row-start-7', '.row-start-7{grid-row-start:7;}'],
            ['row-start-13', '.row-start-13{grid-row-start:13;}'],
            ['row-start-auto', '.row-start-auto{grid-row-start:auto;}'],

            // End classes
            ['row-end-1', '.row-end-1{grid-row-end:1;}'],
            ['row-end-8', '.row-end-8{grid-row-end:8;}'],
            ['row-end-13', '.row-end-13{grid-row-end:13;}'],
            ['row-end-auto', '.row-end-auto{grid-row-end:auto;}'],

            // Auto class
            ['row-auto', '.row-auto{grid-row:auto;}'],

            // Arbitrary value classes
            ['row-[1/3]', '.row-\[1\/3\]{grid-row:1/3;}'],
            ['row-[span_2/3]', '.row-\[span_2\/3\]{grid-row:span 2/3;}'],
            ['row-[7]', '.row-\[7\]{grid-row:7;}'],
            ['row-start-[4]', '.row-start-\[4\]{grid-row-start:4;}'],
            ['row-end-[7]', '.row-end-\[7\]{grid-row-end:7;}'],
        ];
    }

    public function test_invalid_grid_row_class(): void
    {
        $this->assertNull(GridRowUtilityClass::parse('row-invalid'));
    }

    public function test_grid_row_class_with_invalid_value(): void
    {
        $gridRowClass = new GridRowUtilityClass('invalid');
        $this->assertSame('', $gridRowClass->toCss());
    }

    #[DataProvider('outOfRangeValuesProvider')]
    public function test_out_of_range_values(string $input): void
    {
        $gridRowClass = GridRowUtilityClass::parse($input);
        $this->assertInstanceOf(GridRowUtilityClass::class, $gridRowClass);
        $this->assertSame('', $gridRowClass->toCss());
    }

    public static function outOfRangeValuesProvider(): array
    {
        return [
            ['row-span-0'],
            ['row-span-13'],
            ['row-start-0'],
            ['row-start-14'],
            ['row-end-0'],
            ['row-end-14'],
        ];
    }

    public function test_arbitrary_value_escaping(): void
    {
        $input = 'row-[2,3]';
        $expected = '.row-\[2\2c 3\]{grid-row:2,3;}';
        $gridRowClass = GridRowUtilityClass::parse($input);
        $this->assertInstanceOf(GridRowUtilityClass::class, $gridRowClass);
        $this->assertSame($expected, $gridRowClass->toCss());
    }
}
