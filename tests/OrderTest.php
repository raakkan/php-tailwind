<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\OrderClass;

class OrderTest extends TestCase
{
    #[DataProvider('orderClassProvider')]
    public function testOrderClass(string $input, string $expected): void
    {
        $orderClass = OrderClass::parse($input);
        $this->assertInstanceOf(OrderClass::class, $orderClass);
        $this->assertSame($expected, $orderClass->toCss());
    }

    public static function orderClassProvider(): array
    {
        return [
            // Standard values
            ['order-1', '.order-1{order:1;}'],
            ['order-2', '.order-2{order:2;}'],
            ['order-3', '.order-3{order:3;}'],
            ['order-4', '.order-4{order:4;}'],
            ['order-5', '.order-5{order:5;}'],
            ['order-6', '.order-6{order:6;}'],
            ['order-7', '.order-7{order:7;}'],
            ['order-8', '.order-8{order:8;}'],
            ['order-9', '.order-9{order:9;}'],
            ['order-10', '.order-10{order:10;}'],
            ['order-11', '.order-11{order:11;}'],
            ['order-12', '.order-12{order:12;}'],

            // Special values
            ['order-first', '.order-first{order:-9999;}'],
            ['order-last', '.order-last{order:9999;}'],
            ['order-none', '.order-none{order:0;}'],

            // Arbitrary values
            ['order-[13]', '.order-\[13\]{order:13;}'],
            ['order-[-1]', '.order-\[-1\]{order:-1;}'],
            ['order-[99]', '.order-\[99\]{order:99;}'],
        ];
    }

    public function testInvalidOrderClass(): void
    {
        $this->assertNull(OrderClass::parse('invalid-class'));
    }

    public function testOrderClassWithInvalidValue(): void
    {
        $orderClass = OrderClass::parse('order-invalid');
        $this->assertInstanceOf(OrderClass::class, $orderClass);
        $this->assertSame('', $orderClass->toCss());
    }

    #[DataProvider('invalidArbitraryValuesProvider')]
    public function testInvalidArbitraryValues(string $input): void
    {
        $orderClass = OrderClass::parse($input);
        $this->assertInstanceOf(OrderClass::class, $orderClass);
        $this->assertSame('', $orderClass->toCss());
    }

    public static function invalidArbitraryValuesProvider(): array
    {
        return [
            ['order-[invalid]'],
            ['order-[10px]'],
            ['order-[10%]'],
        ];
    }
}
