<?php

namespace Raakkan\PhpTailwind\Tests\Sizing;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Sizing\HeightClass;

class HeightTest extends TestCase
{
    #[DataProvider('heightClassProvider')]
    public function testHeightClass(string $input, string $expected): void
    {
        $heightClass = HeightClass::parse($input);
        $this->assertInstanceOf(HeightClass::class, $heightClass);
        $this->assertSame($expected, $heightClass->toCss());
    }

    public static function heightClassProvider(): array
    {
        return [
            // Fixed heights
            ['h-0', '.h-0{height:0px;}'],
            ['h-px', '.h-px{height:1px;}'],
            ['h-0.5', '.h-0\.5{height:0.125rem;}'],
            ['h-1', '.h-1{height:0.25rem;}'],
            ['h-1.5', '.h-1\.5{height:0.375rem;}'],
            ['h-2', '.h-2{height:0.5rem;}'],
            ['h-4', '.h-4{height:1rem;}'],
            ['h-8', '.h-8{height:2rem;}'],
            ['h-12', '.h-12{height:3rem;}'],
            ['h-16', '.h-16{height:4rem;}'],
            ['h-20', '.h-20{height:5rem;}'],
            ['h-24', '.h-24{height:6rem;}'],
            ['h-32', '.h-32{height:8rem;}'],
            ['h-40', '.h-40{height:10rem;}'],
            ['h-48', '.h-48{height:12rem;}'],
            ['h-56', '.h-56{height:14rem;}'],
            ['h-64', '.h-64{height:16rem;}'],
            ['h-72', '.h-72{height:18rem;}'],
            ['h-80', '.h-80{height:20rem;}'],
            ['h-96', '.h-96{height:24rem;}'],

            // Percentage heights
            ['h-auto', '.h-auto{height:auto;}'],
            ['h-1/2', '.h-1\/2{height:50%;}'],
            ['h-1/3', '.h-1\/3{height:33.333333%;}'],
            ['h-2/3', '.h-2\/3{height:66.666667%;}'],
            ['h-1/4', '.h-1\/4{height:25%;}'],
            ['h-2/4', '.h-2\/4{height:50%;}'],
            ['h-3/4', '.h-3\/4{height:75%;}'],
            ['h-1/5', '.h-1\/5{height:20%;}'],
            ['h-2/5', '.h-2\/5{height:40%;}'],
            ['h-3/5', '.h-3\/5{height:60%;}'],
            ['h-4/5', '.h-4\/5{height:80%;}'],
            ['h-1/6', '.h-1\/6{height:16.666667%;}'],
            ['h-5/6', '.h-5\/6{height:83.333333%;}'],
            ['h-full', '.h-full{height:100%;}'],

            // Special heights
            ['h-screen', '.h-screen{height:100vh;}'],
            ['h-svh', '.h-svh{height:100svh;}'],
            ['h-lvh', '.h-lvh{height:100lvh;}'],
            ['h-dvh', '.h-dvh{height:100dvh;}'],
            ['h-min', '.h-min{height:min-content;}'],
            ['h-max', '.h-max{height:max-content;}'],
            ['h-fit', '.h-fit{height:fit-content;}'],

            // Arbitrary values
            ['h-[10px]', '.h-\[10px\]{height:10px;}'],
            ['h-[2rem]', '.h-\[2rem\]{height:2rem;}'],
            ['h-[50%]', '.h-\[50\%\]{height:50%;}'],
            ['h-[7vh]', '.h-\[7vh\]{height:7vh;}'],
            ['h-[calc(100%-1rem)]', '.h-\[calc\(100\%-1rem\)\]{height:calc(100%-1rem);}'],
        ];
    }

    public function testInvalidHeightClass(): void
    {
        $this->assertNull(HeightClass::parse('invalid-class'));
    }

    public function testHeightClassWithInvalidValue(): void
    {
        $heightClass = HeightClass::parse('h-invalid');
        $this->assertInstanceOf(HeightClass::class, $heightClass);
        $this->assertSame('', $heightClass->toCss());
    }

    #[DataProvider('invalidArbitraryHeightProvider')]
    public function testInvalidArbitraryHeight(string $input): void
    {
        $heightClass = HeightClass::parse($input);
        $this->assertInstanceOf(HeightClass::class, $heightClass);
        $this->assertSame('', $heightClass->toCss());
    }

    public static function invalidArbitraryHeightProvider(): array
    {
        return [
            ['h-[invalid]'],
            ['h-[10]'],
            ['h-[rem]'],
            ['h-[calc()]'],
        ];
    }

    #[DataProvider('validArbitraryHeightProvider')]
    public function testValidArbitraryHeight(string $input, string $expected): void
    {
        $heightClass = HeightClass::parse($input);
        $this->assertInstanceOf(HeightClass::class, $heightClass);
        $this->assertSame($expected, $heightClass->toCss());
    }

    public static function validArbitraryHeightProvider(): array
    {
        return [
            ['h-[100px]', '.h-\[100px\]{height:100px;}'],
            ['h-[13.5rem]', '.h-\[13\.5rem\]{height:13.5rem;}'],
            ['h-[-25%]', '.h-\[-25\%\]{height:-25%;}'],
            ['h-[calc(100%+1rem)]', '.h-\[calc\(100\%\+1rem\)\]{height:calc(100%+1rem);}'],
            ['h-[clamp(200px,50%,300px)]', '.h-\[clamp\(200px\2c 50\%\2c 300px\)\]{height:clamp(200px,50%,300px);}'],
            ['h-[50svh]', '.h-\[50svh\]{height:50svh;}'],
            ['h-[75lvh]', '.h-\[75lvh\]{height:75lvh;}'],
            ['h-[90dvh]', '.h-\[90dvh\]{height:90dvh;}'],
        ];
    }

    #[DataProvider('newViewportUnitsProvider')]
    public function testNewViewportUnits(string $input, string $expected): void
    {
        $heightClass = HeightClass::parse($input);
        $this->assertInstanceOf(HeightClass::class, $heightClass);
        $this->assertSame($expected, $heightClass->toCss());
    }

    public static function newViewportUnitsProvider(): array
    {
        return [
            ['h-svh', '.h-svh{height:100svh;}'],
            ['h-lvh', '.h-lvh{height:100lvh;}'],
            ['h-dvh', '.h-dvh{height:100dvh;}'],
            ['h-[50svh]', '.h-\[50svh\]{height:50svh;}'],
            ['h-[75lvh]', '.h-\[75lvh\]{height:75lvh;}'],
            ['h-[90dvh]', '.h-\[90dvh\]{height:90dvh;}'],
        ];
    }
}
