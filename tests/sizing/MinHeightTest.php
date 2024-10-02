<?php

namespace Raakkan\PhpTailwind\Tests\Sizing;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Sizing\MinHeightClass;
use PHPUnit\Framework\Attributes\DataProvider;

class MinHeightTest extends TestCase
{
    #[DataProvider('minHeightClassProvider')]
    public function testMinHeightClass(string $input, string $expected): void
    {
        $minHeightClass = MinHeightClass::parse($input);
        $this->assertInstanceOf(MinHeightClass::class, $minHeightClass);
        $this->assertSame($expected, $minHeightClass->toCss());
    }

    public static function minHeightClassProvider(): array
    {
        return [
            // Core values
            ['min-h-0', '.min-h-0{min-height:0px;}'],
            ['min-h-full', '.min-h-full{min-height:100%;}'],
            ['min-h-screen', '.min-h-screen{min-height:100vh;}'],
            ['min-h-min', '.min-h-min{min-height:min-content;}'],
            ['min-h-max', '.min-h-max{min-height:max-content;}'],
            ['min-h-fit', '.min-h-fit{min-height:fit-content;}'],
            ['min-h-svh', '.min-h-svh{min-height:100svh;}'],
            ['min-h-lvh', '.min-h-lvh{min-height:100lvh;}'],
            ['min-h-dvh', '.min-h-dvh{min-height:100dvh;}'],

            // Spacing scale values
            ['min-h-px', '.min-h-px{min-height:1px;}'],
            ['min-h-0.5', '.min-h-0\.5{min-height:0.125rem;}'],
            ['min-h-1', '.min-h-1{min-height:0.25rem;}'],
            ['min-h-1.5', '.min-h-1\.5{min-height:0.375rem;}'],
            ['min-h-2', '.min-h-2{min-height:0.5rem;}'],
            ['min-h-2.5', '.min-h-2\.5{min-height:0.625rem;}'],
            ['min-h-3', '.min-h-3{min-height:0.75rem;}'],
            ['min-h-3.5', '.min-h-3\.5{min-height:0.875rem;}'],
            ['min-h-4', '.min-h-4{min-height:1rem;}'],
            ['min-h-5', '.min-h-5{min-height:1.25rem;}'],
            ['min-h-6', '.min-h-6{min-height:1.5rem;}'],
            ['min-h-7', '.min-h-7{min-height:1.75rem;}'],
            ['min-h-8', '.min-h-8{min-height:2rem;}'],
            ['min-h-9', '.min-h-9{min-height:2.25rem;}'],
            ['min-h-10', '.min-h-10{min-height:2.5rem;}'],
            ['min-h-11', '.min-h-11{min-height:2.75rem;}'],
            ['min-h-12', '.min-h-12{min-height:3rem;}'],
            ['min-h-14', '.min-h-14{min-height:3.5rem;}'],
            ['min-h-16', '.min-h-16{min-height:4rem;}'],
            ['min-h-20', '.min-h-20{min-height:5rem;}'],
            ['min-h-24', '.min-h-24{min-height:6rem;}'],
            ['min-h-28', '.min-h-28{min-height:7rem;}'],
            ['min-h-32', '.min-h-32{min-height:8rem;}'],
            ['min-h-36', '.min-h-36{min-height:9rem;}'],
            ['min-h-40', '.min-h-40{min-height:10rem;}'],
            ['min-h-44', '.min-h-44{min-height:11rem;}'],
            ['min-h-48', '.min-h-48{min-height:12rem;}'],
            ['min-h-52', '.min-h-52{min-height:13rem;}'],
            ['min-h-56', '.min-h-56{min-height:14rem;}'],
            ['min-h-60', '.min-h-60{min-height:15rem;}'],
            ['min-h-64', '.min-h-64{min-height:16rem;}'],
            ['min-h-72', '.min-h-72{min-height:18rem;}'],
            ['min-h-80', '.min-h-80{min-height:20rem;}'],
            ['min-h-96', '.min-h-96{min-height:24rem;}'],

            // Arbitrary values
            ['min-h-[10px]', '.min-h-\[10px\]{min-height:10px;}'],
            ['min-h-[2rem]', '.min-h-\[2rem\]{min-height:2rem;}'],
            ['min-h-[50%]', '.min-h-\[50\%\]{min-height:50%;}'],
            ['min-h-[100vh]', '.min-h-\[100vh\]{min-height:100vh;}'],
            ['min-h-[calc(100%-1rem)]', '.min-h-\[calc\(100\%-1rem\)\]{min-height:calc(100%-1rem);}'],
            ['min-h-[clamp(200px,50%,300px)]', '.min-h-\[clamp\(200px\2c 50\%\2c 300px\)\]{min-height:clamp(200px,50%,300px);}'],
        ];
    }

    public function testInvalidMinHeightClass(): void
    {
        $this->assertNull(MinHeightClass::parse('invalid-class'));
    }

    public function testMinHeightClassWithInvalidValue(): void
    {
        $minHeightClass = MinHeightClass::parse('min-h-invalid');
        $this->assertInstanceOf(MinHeightClass::class, $minHeightClass);
        $this->assertSame('', $minHeightClass->toCss());
    }

    #[DataProvider('invalidArbitraryMinHeightProvider')]
    public function testInvalidArbitraryMinHeight(string $input): void
    {
        $minHeightClass = MinHeightClass::parse($input);
        $this->assertInstanceOf(MinHeightClass::class, $minHeightClass);
        $this->assertSame('', $minHeightClass->toCss());
    }

    public static function invalidArbitraryMinHeightProvider(): array
    {
        return [
            ['min-h-[invalid]'],
            ['min-h-[10]'],
            ['min-h-[rem]'],
            ['min-h-[calc()]'],
            ['min-h-[]'],
            ['min-h-[.]'],
        ];
    }

    #[DataProvider('validArbitraryMinHeightProvider')]
    public function testValidArbitraryMinHeight(string $input, string $expected): void
    {
        $minHeightClass = MinHeightClass::parse($input);
        $this->assertInstanceOf(MinHeightClass::class, $minHeightClass);
        $this->assertSame($expected, $minHeightClass->toCss());
    }

    public static function validArbitraryMinHeightProvider(): array
    {
        return [
            ['min-h-[100px]', '.min-h-\[100px\]{min-height:100px;}'],
            ['min-h-[13.5rem]', '.min-h-\[13\.5rem\]{min-height:13.5rem;}'],
            ['min-h-[-25%]', '.min-h-\[-25\%\]{min-height:-25%;}'],
            ['min-h-[calc(100%+1rem)]', '.min-h-\[calc\(100\%\+1rem\)\]{min-height:calc(100%+1rem);}'],
            ['min-h-[clamp(200px,50%,300px)]', '.min-h-\[clamp\(200px\2c 50\%\2c 300px\)\]{min-height:clamp(200px,50%,300px);}'],
            ['min-h-[max(50%,300px)]', '.min-h-\[max\(50\%\2c 300px\)\]{min-height:max(50%,300px);}'],
            ['min-h-[min(50%,300px)]', '.min-h-\[min\(50\%\2c 300px\)\]{min-height:min(50%,300px);}'],
        ];
    }

    #[DataProvider('viewportUnitsProvider')]
    public function testViewportUnits(string $input, string $expected): void
    {
        $minHeightClass = MinHeightClass::parse($input);
        $this->assertInstanceOf(MinHeightClass::class, $minHeightClass);
        $this->assertSame($expected, $minHeightClass->toCss());
    }

    public static function viewportUnitsProvider(): array
    {
        return [
            ['min-h-screen', '.min-h-screen{min-height:100vh;}'],
            ['min-h-svh', '.min-h-svh{min-height:100svh;}'],
            ['min-h-lvh', '.min-h-lvh{min-height:100lvh;}'],
            ['min-h-dvh', '.min-h-dvh{min-height:100dvh;}'],
            ['min-h-[50vh]', '.min-h-\[50vh\]{min-height:50vh;}'],
            ['min-h-[75svh]', '.min-h-\[75svh\]{min-height:75svh;}'],
            ['min-h-[80lvh]', '.min-h-\[80lvh\]{min-height:80lvh;}'],
            ['min-h-[90dvh]', '.min-h-\[90dvh\]{min-height:90dvh;}'],
        ];
    }
}