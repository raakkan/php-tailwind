<?php

namespace Raakkan\PhpTailwind\Tests\Sizing;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Sizing\WidthClass;
use PHPUnit\Framework\Attributes\DataProvider;

class WidthTest extends TestCase
{
    #[DataProvider('widthClassProvider')]
    public function testWidthClass(string $input, string $expected): void
    {
        $widthClass = WidthClass::parse($input);
        $this->assertInstanceOf(WidthClass::class, $widthClass);
        $this->assertSame($expected, $widthClass->toCss());
    }

    public static function widthClassProvider(): array
    {
        return [
            // Fixed widths
            ['w-0', '.w-0{width:0px;}'],
            ['w-px', '.w-px{width:1px;}'],
            ['w-0.5', '.w-0\.5{width:0.125rem;}'],
            ['w-1', '.w-1{width:0.25rem;}'],
            ['w-1.5', '.w-1\.5{width:0.375rem;}'],
            ['w-2', '.w-2{width:0.5rem;}'],
            ['w-4', '.w-4{width:1rem;}'],
            ['w-8', '.w-8{width:2rem;}'],
            ['w-12', '.w-12{width:3rem;}'],
            ['w-16', '.w-16{width:4rem;}'],
            ['w-20', '.w-20{width:5rem;}'],
            ['w-24', '.w-24{width:6rem;}'],
            ['w-32', '.w-32{width:8rem;}'],
            ['w-40', '.w-40{width:10rem;}'],
            ['w-48', '.w-48{width:12rem;}'],
            ['w-56', '.w-56{width:14rem;}'],
            ['w-64', '.w-64{width:16rem;}'],
            ['w-72', '.w-72{width:18rem;}'],
            ['w-80', '.w-80{width:20rem;}'],
            ['w-96', '.w-96{width:24rem;}'],

            // Percentage widths
            ['w-auto', '.w-auto{width:auto;}'],
            ['w-1/2', '.w-1/2{width:50%;}'],
            ['w-1/3', '.w-1/3{width:33.333333%;}'],
            ['w-2/3', '.w-2/3{width:66.666667%;}'],
            ['w-1/4', '.w-1/4{width:25%;}'],
            ['w-2/4', '.w-2/4{width:50%;}'],
            ['w-3/4', '.w-3/4{width:75%;}'],
            ['w-1/5', '.w-1/5{width:20%;}'],
            ['w-2/5', '.w-2/5{width:40%;}'],
            ['w-3/5', '.w-3/5{width:60%;}'],
            ['w-4/5', '.w-4/5{width:80%;}'],
            ['w-1/6', '.w-1/6{width:16.666667%;}'],
            ['w-5/6', '.w-5/6{width:83.333333%;}'],
            ['w-full', '.w-full{width:100%;}'],

            // Special widths
            ['w-screen', '.w-screen{width:100vw;}'],
            ['w-svw', '.w-svw{width:100svw;}'],
            ['w-lvw', '.w-lvw{width:100lvw;}'],
            ['w-dvw', '.w-dvw{width:100dvw;}'],
            ['w-min', '.w-min{width:min-content;}'],
            ['w-max', '.w-max{width:max-content;}'],
            ['w-fit', '.w-fit{width:fit-content;}'],

            // Arbitrary values
            ['w-[10px]', '.w-\[10px\]{width:10px;}'],
            ['w-[2rem]', '.w-\[2rem\]{width:2rem;}'],
            ['w-[50%]', '.w-\[50\%\]{width:50%;}'],
            ['w-[7vw]', '.w-\[7vw\]{width:7vw;}'],
            ['w-[calc(100%-1rem)]', '.w-\[calc\(100\%-1rem\)\]{width:calc(100%-1rem);}'],
        ];
    }

    public function testInvalidWidthClass(): void
    {
        $this->assertNull(WidthClass::parse('invalid-class'));
    }

    public function testWidthClassWithInvalidValue(): void
    {
        $widthClass = WidthClass::parse('w-invalid');
        $this->assertInstanceOf(WidthClass::class, $widthClass);
        $this->assertSame('', $widthClass->toCss());
    }

    #[DataProvider('invalidArbitraryWidthProvider')]
    public function testInvalidArbitraryWidth(string $input): void
    {
        $widthClass = WidthClass::parse($input);
        $this->assertInstanceOf(WidthClass::class, $widthClass);
        $this->assertSame('', $widthClass->toCss());
    }

    public static function invalidArbitraryWidthProvider(): array
    {
        return [
            ['w-[invalid]'],
            ['w-[10]'],
            ['w-[rem]'],
            ['w-[calc()]'],
        ];
    }

    #[DataProvider('validArbitraryWidthProvider')]
    public function testValidArbitraryWidth(string $input, string $expected): void
    {
        $widthClass = WidthClass::parse($input);
        $this->assertInstanceOf(WidthClass::class, $widthClass);
        $this->assertSame($expected, $widthClass->toCss());
    }

    public static function validArbitraryWidthProvider(): array
    {
        return [
            ['w-[100px]', '.w-\[100px\]{width:100px;}'],
            ['w-[13.5rem]', '.w-\[13\.5rem\]{width:13.5rem;}'],
            ['w-[-25%]', '.w-\[-25\%\]{width:-25%;}'],
            ['w-[calc(100%+1rem)]', '.w-\[calc\(100\%\+1rem\)\]{width:calc(100%+1rem);}'],
            ['w-[clamp(200px,50%,300px)]', '.w-\[clamp\(200px\2c 50\%\\2c 300px\)\]{width:clamp(200px,50%,300px);}'],
        ];
    }
}