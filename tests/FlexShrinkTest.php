<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\FlexShrinkClass;

class FlexShrinkTest extends TestCase
{
    #[DataProvider('flexShrinkClassProvider')]
    public function testFlexShrinkClass(string $input, string $expected): void
    {
        $flexShrinkClass = FlexShrinkClass::parse($input);
        $this->assertInstanceOf(FlexShrinkClass::class, $flexShrinkClass);
        $this->assertSame($expected, $flexShrinkClass->toCss());
    }

    public static function flexShrinkClassProvider(): array
    {
        return [
            // Standard values
            ['shrink-0', '.shrink-0{flex-shrink:0;}'],
            ['shrink', '.shrink{flex-shrink:1;}'],

            // Arbitrary values
            ['shrink-[2]', '.shrink-\[2\]{flex-shrink:2;}'],
            ['shrink-[0.5]', '.shrink-\[0\.5\]{flex-shrink:0.5;}'],
            ['shrink-[3.7]', '.shrink-\[3\.7\]{flex-shrink:3.7;}'],
            ['shrink-[calc(1+1)]', '.shrink-\[calc\(1\+1\)\]{flex-shrink:calc(1+1);}'],
        ];
    }

    public function testInvalidFlexShrinkClass(): void
    {
        $this->assertNull(FlexShrinkClass::parse('invalid-class'));
    }

    #[DataProvider('invalidFlexShrinkValuesProvider')]
    public function testFlexShrinkClassWithInvalidValue(string $input): void
    {
        $flexShrinkClass = FlexShrinkClass::parse($input);
        $this->assertInstanceOf(FlexShrinkClass::class, $flexShrinkClass);
        $this->assertSame('', $flexShrinkClass->toCss());
    }

    public static function invalidFlexShrinkValuesProvider(): array
    {
        return [
            ['shrink-invalid'],
            ['shrink-1'], // Only 0 is valid for non-arbitrary values
            ['shrink-[invalid]'],
            ['shrink-[1px]'], // Should be a number, not a length
            ['shrink-[]'], // Empty brackets
        ];
    }

    #[DataProvider('escapingTestProvider')]
    public function testProperEscaping(string $input, string $expected): void
    {
        $flexShrinkClass = FlexShrinkClass::parse($input);
        $this->assertInstanceOf(FlexShrinkClass::class, $flexShrinkClass);
        $this->assertSame($expected, $flexShrinkClass->toCss());
    }

    public static function escapingTestProvider(): array
    {
        return [
            ['shrink-[1.5]', '.shrink-\[1\.5\]{flex-shrink:1.5;}'],
            ['shrink-[2/3]', '.shrink-\[2\/3\]{flex-shrink:2/3;}'],
            ['shrink-[calc(2+3)]', '.shrink-\[calc\(2\+3\)\]{flex-shrink:calc(2+3);}'],
        ];
    }
}
