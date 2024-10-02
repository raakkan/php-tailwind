<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\FlexGrid\FlexBasisClass;
use PHPUnit\Framework\Attributes\DataProvider;

class FlexBasisTest extends TestCase
{
    #[DataProvider('flexBasisClassProvider')]
    public function testFlexBasisClass(string $input, string $expected): void
    {
        $flexBasisClass = FlexBasisClass::parse($input);
        $this->assertInstanceOf(FlexBasisClass::class, $flexBasisClass);
        $this->assertSame($expected, $flexBasisClass->toCss());
    }

    public static function flexBasisClassProvider(): array
    {
        return [
            // Standard values
            ['basis-0', '.basis-0{flex-basis:0px;}'],
            ['basis-1', '.basis-1{flex-basis:0.25rem;}'],
            ['basis-2', '.basis-2{flex-basis:0.5rem;}'],
            ['basis-4', '.basis-4{flex-basis:1rem;}'],
            ['basis-8', '.basis-8{flex-basis:2rem;}'],
            ['basis-12', '.basis-12{flex-basis:3rem;}'],
            ['basis-16', '.basis-16{flex-basis:4rem;}'],
            
            // Fractional values
            ['basis-1/2', '.basis-1\/2{flex-basis:50%;}'],
            ['basis-1/3', '.basis-1\/3{flex-basis:33.333333%;}'],
            ['basis-2/3', '.basis-2\/3{flex-basis:66.666667%;}'],
            ['basis-1/4', '.basis-1\/4{flex-basis:25%;}'],
            ['basis-3/4', '.basis-3\/4{flex-basis:75%;}'],
            ['basis-1/5', '.basis-1\/5{flex-basis:20%;}'],
            ['basis-2/5', '.basis-2\/5{flex-basis:40%;}'],
            ['basis-3/5', '.basis-3\/5{flex-basis:60%;}'],
            ['basis-4/5', '.basis-4\/5{flex-basis:80%;}'],
            ['basis-1/6', '.basis-1\/6{flex-basis:16.666667%;}'],
            ['basis-5/6', '.basis-5\/6{flex-basis:83.333333%;}'],
            ['basis-1/12', '.basis-1\/12{flex-basis:8.333333%;}'],
            ['basis-5/12', '.basis-5\/12{flex-basis:41.666667%;}'],
            ['basis-7/12', '.basis-7\/12{flex-basis:58.333333%;}'],
            ['basis-11/12', '.basis-11\/12{flex-basis:91.666667%;}'],
            
            // Special values
            ['basis-auto', '.basis-auto{flex-basis:auto;}'],
            ['basis-full', '.basis-full{flex-basis:100%;}'],
            ['basis-px', '.basis-px{flex-basis:1px;}'],
            
            // Arbitrary values
            ['basis-[14px]', '.basis-\[14px\]{flex-basis:14px;}'],
            ['basis-[3.23rem]', '.basis-\[3\.23rem\]{flex-basis:3.23rem;}'],
            ['basis-[60%]', '.basis-\[60\%\]{flex-basis:60%;}'],
            
            // Decimal values
            ['basis-0.5', '.basis-0\.5{flex-basis:0.125rem;}'],
            ['basis-1.5', '.basis-1\.5{flex-basis:0.375rem;}'],
            ['basis-2.5', '.basis-2\.5{flex-basis:0.625rem;}'],
            
            // Larger values
            ['basis-72', '.basis-72{flex-basis:18rem;}'],
            ['basis-80', '.basis-80{flex-basis:20rem;}'],
            ['basis-96', '.basis-96{flex-basis:24rem;}'],
        ];
    }

    public function testInvalidFlexBasisClass(): void
    {
        $this->assertNull(FlexBasisClass::parse('invalid-class'));
    }

    public function testFlexBasisClassWithInvalidValue(): void
    {
        $flexBasisClass = FlexBasisClass::parse('basis-invalid');
        $this->assertInstanceOf(FlexBasisClass::class, $flexBasisClass);
        $this->assertSame('', $flexBasisClass->toCss());
    }

    #[DataProvider('invalidArbitraryValuesProvider')]
    public function testInvalidArbitraryValues(string $input): void
    {
        $flexBasisClass = FlexBasisClass::parse($input);
        $this->assertInstanceOf(FlexBasisClass::class, $flexBasisClass);
        $this->assertSame('', $flexBasisClass->toCss());
    }

    public static function invalidArbitraryValuesProvider(): array
    {
        return [
            ['basis-[invalid]'],
            ['basis-[10]'],
            ['basis-[10px10px]'],
        ];
    }

}