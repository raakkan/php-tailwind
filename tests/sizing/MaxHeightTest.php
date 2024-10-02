<?php

namespace Raakkan\PhpTailwind\Tests\Sizing;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Sizing\MaxHeightClass;
use PHPUnit\Framework\Attributes\DataProvider;

class MaxHeightTest extends TestCase
{
    #[DataProvider('maxHeightClassProvider')]
    public function testMaxHeightClass(string $input, string $expected): void
    {
        $maxHeightClass = MaxHeightClass::parse($input);
        $this->assertInstanceOf(MaxHeightClass::class, $maxHeightClass);
        $this->assertSame($expected, $maxHeightClass->toCss());
    }

    public static function maxHeightClassProvider(): array
    {
        return [
            // Core values
            ['max-h-0', '.max-h-0{max-height:0px;}'],
            ['max-h-px', '.max-h-px{max-height:1px;}'],
            ['max-h-full', '.max-h-full{max-height:100%;}'],
            ['max-h-screen', '.max-h-screen{max-height:100vh;}'],
            ['max-h-min', '.max-h-min{max-height:min-content;}'],
            ['max-h-max', '.max-h-max{max-height:max-content;}'],
            ['max-h-fit', '.max-h-fit{max-height:fit-content;}'],

            // New viewport units
            ['max-h-svh', '.max-h-svh{max-height:100svh;}'],
            ['max-h-lvh', '.max-h-lvh{max-height:100lvh;}'],
            ['max-h-dvh', '.max-h-dvh{max-height:100dvh;}'],

            // Numeric values (spacing scale)
            ['max-h-0', '.max-h-0{max-height:0px;}'],
            ['max-h-0.5', '.max-h-0\.5{max-height:0.125rem;}'],
            ['max-h-1', '.max-h-1{max-height:0.25rem;}'],
            ['max-h-1.5', '.max-h-1\.5{max-height:0.375rem;}'],
            ['max-h-2', '.max-h-2{max-height:0.5rem;}'],
            ['max-h-2.5', '.max-h-2\.5{max-height:0.625rem;}'],
            ['max-h-3', '.max-h-3{max-height:0.75rem;}'],
            ['max-h-3.5', '.max-h-3\.5{max-height:0.875rem;}'],
            ['max-h-4', '.max-h-4{max-height:1rem;}'],
            ['max-h-5', '.max-h-5{max-height:1.25rem;}'],
            ['max-h-6', '.max-h-6{max-height:1.5rem;}'],
            ['max-h-7', '.max-h-7{max-height:1.75rem;}'],
            ['max-h-8', '.max-h-8{max-height:2rem;}'],
            ['max-h-9', '.max-h-9{max-height:2.25rem;}'],
            ['max-h-10', '.max-h-10{max-height:2.5rem;}'],
            ['max-h-11', '.max-h-11{max-height:2.75rem;}'],
            ['max-h-12', '.max-h-12{max-height:3rem;}'],
            ['max-h-14', '.max-h-14{max-height:3.5rem;}'],
            ['max-h-16', '.max-h-16{max-height:4rem;}'],
            ['max-h-20', '.max-h-20{max-height:5rem;}'],
            ['max-h-24', '.max-h-24{max-height:6rem;}'],
            ['max-h-28', '.max-h-28{max-height:7rem;}'],
            ['max-h-32', '.max-h-32{max-height:8rem;}'],
            ['max-h-36', '.max-h-36{max-height:9rem;}'],
            ['max-h-40', '.max-h-40{max-height:10rem;}'],
            ['max-h-44', '.max-h-44{max-height:11rem;}'],
            ['max-h-48', '.max-h-48{max-height:12rem;}'],
            ['max-h-52', '.max-h-52{max-height:13rem;}'],
            ['max-h-56', '.max-h-56{max-height:14rem;}'],
            ['max-h-60', '.max-h-60{max-height:15rem;}'],
            ['max-h-64', '.max-h-64{max-height:16rem;}'],
            ['max-h-72', '.max-h-72{max-height:18rem;}'],
            ['max-h-80', '.max-h-80{max-height:20rem;}'],
            ['max-h-96', '.max-h-96{max-height:24rem;}'],

            // Arbitrary values
            ['max-h-[100px]', '.max-h-\[100px\]{max-height:100px;}'],
            ['max-h-[20%]', '.max-h-\[20\%\]{max-height:20%;}'],
            ['max-h-[500px]', '.max-h-\[500px\]{max-height:500px;}'],
            ['max-h-[23rem]', '.max-h-\[23rem\]{max-height:23rem;}'],
            ['max-h-[calc(100%-2rem)]', '.max-h-\[calc\(100\%-2rem\)\]{max-height:calc(100%-2rem);}'],
            ['max-h-[clamp(200px,50%,300px)]', '.max-h-\[clamp\(200px\2c 50\%\2c 300px\)\]{max-height:clamp(200px,50%,300px);}'],
            ['max-h-[50vh]', '.max-h-\[50vh\]{max-height:50vh;}'],
            ['max-h-[75svh]', '.max-h-\[75svh\]{max-height:75svh;}'],
            ['max-h-[80lvh]', '.max-h-\[80lvh\]{max-height:80lvh;}'],
            ['max-h-[90dvh]', '.max-h-\[90dvh\]{max-height:90dvh;}'],
        ];
    }

    public function testInvalidMaxHeightClass(): void
    {
        $this->assertNull(MaxHeightClass::parse('invalid-class'));
    }

    public function testMaxHeightClassWithInvalidValue(): void
    {
        $maxHeightClass = MaxHeightClass::parse('max-h-invalid');
        $this->assertInstanceOf(MaxHeightClass::class, $maxHeightClass);
        $this->assertSame('', $maxHeightClass->toCss());
    }

    #[DataProvider('invalidArbitraryMaxHeightProvider')]
    public function testInvalidArbitraryMaxHeight(string $input): void
    {
        $maxHeightClass = MaxHeightClass::parse($input);
        $this->assertInstanceOf(MaxHeightClass::class, $maxHeightClass);
        $this->assertSame('', $maxHeightClass->toCss());
    }

    public static function invalidArbitraryMaxHeightProvider(): array
    {
        return [
            ['max-h-[invalid]'],
            ['max-h-[10]'],
            ['max-h-[rem]'],
            ['max-h-[calc()]'],
            ['max-h-[]'],
            ['max-h-[.]'],
        ];
    }

    #[DataProvider('validArbitraryMaxHeightProvider')]
    public function testValidArbitraryMaxHeight(string $input, string $expected): void
    {
        $maxHeightClass = MaxHeightClass::parse($input);
        $this->assertInstanceOf(MaxHeightClass::class, $maxHeightClass);
        $this->assertSame($expected, $maxHeightClass->toCss());
    }

    public static function validArbitraryMaxHeightProvider(): array
    {
        return [
            ['max-h-[100px]', '.max-h-\[100px\]{max-height:100px;}'],
            ['max-h-[13.5rem]', '.max-h-\[13\.5rem\]{max-height:13.5rem;}'],
            ['max-h-[50%]', '.max-h-\[50\%\]{max-height:50%;}'],
            ['max-h-[calc(100%-1rem)]', '.max-h-\[calc\(100\%-1rem\)\]{max-height:calc(100%-1rem);}'],
            ['max-h-[clamp(200px,50%,300px)]', '.max-h-\[clamp\(200px\2c 50\%\2c 300px\)\]{max-height:clamp(200px,50%,300px);}'],
            ['max-h-[max(50%,300px)]', '.max-h-\[max\(50\%\2c 300px\)\]{max-height:max(50%,300px);}'],
            ['max-h-[min(50%,300px)]', '.max-h-\[min\(50\%\2c 300px\)\]{max-height:min(50%,300px);}'],
            ['max-h-[50vh]', '.max-h-\[50vh\]{max-height:50vh;}'],
            ['max-h-[75svh]', '.max-h-\[75svh\]{max-height:75svh;}'],
            ['max-h-[80lvh]', '.max-h-\[80lvh\]{max-height:80lvh;}'],
            ['max-h-[90dvh]', '.max-h-\[90dvh\]{max-height:90dvh;}'],
        ];
    }
}