<?php

namespace Raakkan\PhpTailwind\Tests\Sizing;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Sizing\MinWidthClass;
use PHPUnit\Framework\Attributes\DataProvider;

class MinWidthTest extends TestCase
{
    #[DataProvider('minWidthClassProvider')]
    public function testMinWidthClass(string $input, string $expected): void
    {
        $minWidthClass = MinWidthClass::parse($input);
        $this->assertInstanceOf(MinWidthClass::class, $minWidthClass);
        $this->assertSame($expected, $minWidthClass->toCss());
    }

    public static function minWidthClassProvider(): array
    {
        return [
            // Core values
            ['min-w-0', '.min-w-0{min-width:0px;}'],
            ['min-w-full', '.min-w-full{min-width:100%;}'],
            ['min-w-min', '.min-w-min{min-width:min-content;}'],
            ['min-w-max', '.min-w-max{min-width:max-content;}'],
            ['min-w-fit', '.min-w-fit{min-width:fit-content;}'],

            // Spacing scale values
            ['min-w-px', '.min-w-px{min-width:1px;}'],
            ['min-w-0.5', '.min-w-0\.5{min-width:0.125rem;}'],
            ['min-w-1', '.min-w-1{min-width:0.25rem;}'],
            ['min-w-1.5', '.min-w-1\.5{min-width:0.375rem;}'],
            ['min-w-2', '.min-w-2{min-width:0.5rem;}'],
            ['min-w-2.5', '.min-w-2\.5{min-width:0.625rem;}'],
            ['min-w-3', '.min-w-3{min-width:0.75rem;}'],
            ['min-w-3.5', '.min-w-3\.5{min-width:0.875rem;}'],
            ['min-w-4', '.min-w-4{min-width:1rem;}'],
            ['min-w-5', '.min-w-5{min-width:1.25rem;}'],
            ['min-w-6', '.min-w-6{min-width:1.5rem;}'],
            ['min-w-7', '.min-w-7{min-width:1.75rem;}'],
            ['min-w-8', '.min-w-8{min-width:2rem;}'],
            ['min-w-9', '.min-w-9{min-width:2.25rem;}'],
            ['min-w-10', '.min-w-10{min-width:2.5rem;}'],
            ['min-w-11', '.min-w-11{min-width:2.75rem;}'],
            ['min-w-12', '.min-w-12{min-width:3rem;}'],
            ['min-w-14', '.min-w-14{min-width:3.5rem;}'],
            ['min-w-16', '.min-w-16{min-width:4rem;}'],
            ['min-w-20', '.min-w-20{min-width:5rem;}'],
            ['min-w-24', '.min-w-24{min-width:6rem;}'],
            ['min-w-28', '.min-w-28{min-width:7rem;}'],
            ['min-w-32', '.min-w-32{min-width:8rem;}'],
            ['min-w-36', '.min-w-36{min-width:9rem;}'],
            ['min-w-40', '.min-w-40{min-width:10rem;}'],
            ['min-w-44', '.min-w-44{min-width:11rem;}'],
            ['min-w-48', '.min-w-48{min-width:12rem;}'],
            ['min-w-52', '.min-w-52{min-width:13rem;}'],
            ['min-w-56', '.min-w-56{min-width:14rem;}'],
            ['min-w-60', '.min-w-60{min-width:15rem;}'],
            ['min-w-64', '.min-w-64{min-width:16rem;}'],
            ['min-w-72', '.min-w-72{min-width:18rem;}'],
            ['min-w-80', '.min-w-80{min-width:20rem;}'],
            ['min-w-96', '.min-w-96{min-width:24rem;}'],

            // Arbitrary values
            ['min-w-[10px]', '.min-w-\[10px\]{min-width:10px;}'],
            ['min-w-[2rem]', '.min-w-\[2rem\]{min-width:2rem;}'],
            ['min-w-[50%]', '.min-w-\[50\%\]{min-width:50%;}'],
            ['min-w-[100vw]', '.min-w-\[100vw\]{min-width:100vw;}'],
            ['min-w-[calc(100%-1rem)]', '.min-w-\[calc\(100\%-1rem\)\]{min-width:calc(100%-1rem);}'],
            ['min-w-[clamp(200px,50%,300px)]', '.min-w-\[clamp\(200px\2c 50\%\2c 300px\)\]{min-width:clamp(200px,50%,300px);}'],
        ];
    }

    public function testInvalidMinWidthClass(): void
    {
        $this->assertNull(MinWidthClass::parse('invalid-class'));
    }

    public function testMinWidthClassWithInvalidValue(): void
    {
        $minWidthClass = MinWidthClass::parse('min-w-invalid');
        $this->assertInstanceOf(MinWidthClass::class, $minWidthClass);
        $this->assertSame('', $minWidthClass->toCss());
    }

    #[DataProvider('invalidArbitraryMinWidthProvider')]
    public function testInvalidArbitraryMinWidth(string $input): void
    {
        $minWidthClass = MinWidthClass::parse($input);
        $this->assertInstanceOf(MinWidthClass::class, $minWidthClass);
        $this->assertSame('', $minWidthClass->toCss());
    }

    public static function invalidArbitraryMinWidthProvider(): array
    {
        return [
            ['min-w-[invalid]'],
            ['min-w-[10]'],
            ['min-w-[rem]'],
            ['min-w-[calc()]'],
            ['min-w-[]'],
            ['min-w-[.]'],
        ];
    }

    #[DataProvider('validArbitraryMinWidthProvider')]
    public function testValidArbitraryMinWidth(string $input, string $expected): void
    {
        $minWidthClass = MinWidthClass::parse($input);
        $this->assertInstanceOf(MinWidthClass::class, $minWidthClass);
        $this->assertSame($expected, $minWidthClass->toCss());
    }

    public static function validArbitraryMinWidthProvider(): array
    {
        return [
            ['min-w-[100px]', '.min-w-\[100px\]{min-width:100px;}'],
            ['min-w-[13.5rem]', '.min-w-\[13\.5rem\]{min-width:13.5rem;}'],
            ['min-w-[-25%]', '.min-w-\[-25\%\]{min-width:-25%;}'],
            ['min-w-[calc(100%+1rem)]', '.min-w-\[calc\(100\%\+1rem\)\]{min-width:calc(100%+1rem);}'],
            ['min-w-[clamp(200px,50%,300px)]', '.min-w-\[clamp\(200px\2c 50\%\2c 300px\)\]{min-width:clamp(200px,50%,300px);}'],
            ['min-w-[max(50%,300px)]', '.min-w-\[max\(50\%\2c 300px\)\]{min-width:max(50%,300px);}'],
            ['min-w-[min(50%,300px)]', '.min-w-\[min\(50\%\2c 300px\)\]{min-width:min(50%,300px);}'],
        ];
    }
}