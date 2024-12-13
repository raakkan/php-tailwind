<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\FlexClass;

class FlexTest extends TestCase
{
    #[DataProvider('flexClassProvider')]
    public function test_flex_class(string $input, string $expected): void
    {
        $flexClass = FlexClass::parse($input);
        $this->assertInstanceOf(FlexClass::class, $flexClass);
        $this->assertSame($expected, $flexClass->toCss());
    }

    public static function flexClassProvider(): array
    {
        return [
            // Standard values
            ['flex-1', '.flex-1{flex:1 1 0%;}'],
            ['flex-auto', '.flex-auto{flex:1 1 auto;}'],
            ['flex-initial', '.flex-initial{flex:0 1 auto;}'],
            ['flex-none', '.flex-none{flex:none;}'],

            // Arbitrary values
            ['flex-[2]', '.flex-\[2\]{flex:2;}'],
            ['flex-[2_2_0%]', '.flex-\[2_2_0\%\]{flex:2 2 0%;}'],
            ['flex-[1_1_20px]', '.flex-\[1_1_20px\]{flex:1 1 20px;}'],
            ['flex-[0_1_auto]', '.flex-\[0_1_auto\]{flex:0 1 auto;}'],
        ];
    }

    public function test_invalid_flex_class(): void
    {
        $this->assertNull(FlexClass::parse('invalid-class'));
    }

    public function test_flex_class_with_invalid_value(): void
    {
        $flexClass = FlexClass::parse('flex-invalid');
        $this->assertInstanceOf(FlexClass::class, $flexClass);
        $this->assertSame('', $flexClass->toCss());
    }

    #[DataProvider('invalidArbitraryValuesProvider')]
    public function test_invalid_arbitrary_values(string $input): void
    {
        $flexClass = FlexClass::parse($input);
        $this->assertInstanceOf(FlexClass::class, $flexClass);
        $this->assertSame('', $flexClass->toCss());
    }

    public static function invalidArbitraryValuesProvider(): array
    {
        return [
            ['flex-[invalid]'],
            ['flex-[1 1]'], // Missing third value
            ['flex-[1 1 invalid]'],
            ['flex-[1 1 10px 10px]'], // Too many values
        ];
    }
}
