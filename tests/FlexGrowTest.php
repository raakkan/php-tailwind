<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\FlexGrowClass;

class FlexGrowTest extends TestCase
{
    #[DataProvider('flexGrowClassProvider')]
    public function testFlexGrowClass(string $input, string $expected): void
    {
        $flexGrowClass = FlexGrowClass::parse($input);
        $this->assertInstanceOf(FlexGrowClass::class, $flexGrowClass);
        $this->assertSame($expected, $flexGrowClass->toCss());
    }

    public static function flexGrowClassProvider(): array
    {
        return [
            // Standard values
            ['grow-0', '.grow-0{flex-grow:0;}'],
            ['grow', '.grow{flex-grow:1;}'],

            // Arbitrary values
            ['grow-[2]', '.grow-\[2\]{flex-grow:2;}'],
            ['grow-[0.5]', '.grow-\[0\.5\]{flex-grow:0.5;}'],
            ['grow-[3.7]', '.grow-\[3\.7\]{flex-grow:3.7;}'],
        ];
    }

    public function testInvalidFlexGrowClass(): void
    {
        $this->assertNull(FlexGrowClass::parse('invalid-class'));
    }

    #[DataProvider('invalidFlexGrowValuesProvider')]
    public function testFlexGrowClassWithInvalidValue(string $input): void
    {
        $flexGrowClass = FlexGrowClass::parse($input);
        $this->assertInstanceOf(FlexGrowClass::class, $flexGrowClass);
        $this->assertSame('', $flexGrowClass->toCss());
    }

    public static function invalidFlexGrowValuesProvider(): array
    {
        return [
            ['grow-invalid'],
            ['grow-2'], // Only 0 and 1 are valid for non-arbitrary values
            ['grow-[invalid]'],
            ['grow-[1px]'], // Should be a number, not a length
            ['grow-[]'], // Empty brackets
        ];
    }

    #[DataProvider('escapingTestProvider')]
    public function testProperEscaping(string $input, string $expected): void
    {
        $flexGrowClass = FlexGrowClass::parse($input);
        $this->assertInstanceOf(FlexGrowClass::class, $flexGrowClass);
        $this->assertSame($expected, $flexGrowClass->toCss());
    }

    public static function escapingTestProvider(): array
    {
        return [
            ['grow-[1.5]', '.grow-\[1\.5\]{flex-grow:1.5;}'],
            ['grow-[2/3]', '.grow-\[2\/3\]{flex-grow:2/3;}'],
        ];
    }
}
