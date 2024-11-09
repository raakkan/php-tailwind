<?php

namespace Raakkan\PhpTailwind\Tests\SVG;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\SVG\StrokeWidthClass;

class StrokeWidthTest extends TestCase
{
    #[DataProvider('strokeWidthClassProvider')]
    public function testStrokeWidthClass(string $input, string $expected): void
    {
        $strokeWidthClass = StrokeWidthClass::parse($input);
        $this->assertInstanceOf(StrokeWidthClass::class, $strokeWidthClass);
        $this->assertSame($expected, $strokeWidthClass->toCss());
    }

    public static function strokeWidthClassProvider(): array
    {
        return [
            ['stroke-0', '.stroke-0{stroke-width:0;}'],
            ['stroke-1', '.stroke-1{stroke-width:1;}'],
            ['stroke-2', '.stroke-2{stroke-width:2;}'],
            ['stroke-[0.5]', '.stroke-\[0\.5\]{stroke-width:0.5;}'],
            ['stroke-[3px]', '.stroke-\[3px\]{stroke-width:3px;}'],
            ['stroke-[2rem]', '.stroke-\[2rem\]{stroke-width:2rem;}'],
            ['stroke-[5%]', '.stroke-\[5\%\]{stroke-width:5%;}'],
            ['stroke-[calc(1em+3px)]', '.stroke-\[calc\(1em\+3px\)\]{stroke-width:calc(1em+3px);}'],
        ];
    }

    public function testInvalidStrokeWidthClass(): void
    {
        $this->assertNull(StrokeWidthClass::parse('invalid-class'));
    }

    #[DataProvider('invalidStrokeWidthValueProvider')]
    public function testStrokeWidthClassWithInvalidValue(string $input): void
    {
        $strokeWidthClass = StrokeWidthClass::parse($input);
        $this->assertInstanceOf(StrokeWidthClass::class, $strokeWidthClass);
        $this->assertSame('', $strokeWidthClass->toCss());
    }

    public static function invalidStrokeWidthValueProvider(): array
    {
        return [
            ['stroke-3'],
            ['stroke-4'],
            // ['stroke-[invalid]'],
            // ['stroke-[]'],
            // ['stroke-[10px'],
            // ['stroke-10px]'],
        ];
    }

    #[DataProvider('arbitraryStrokeWidthClassProvider')]
    public function testArbitraryStrokeWidthClass(string $input, string $expected): void
    {
        $strokeWidthClass = StrokeWidthClass::parse($input);
        $this->assertInstanceOf(StrokeWidthClass::class, $strokeWidthClass);
        $this->assertSame($expected, $strokeWidthClass->toCss());
    }

    public static function arbitraryStrokeWidthClassProvider(): array
    {
        return [
            ['stroke-[10px]', '.stroke-\[10px\]{stroke-width:10px;}'],
            ['stroke-[2em]', '.stroke-\[2em\]{stroke-width:2em;}'],
            ['stroke-[10vh]', '.stroke-\[10vh\]{stroke-width:10vh;}'],
            ['stroke-[10%]', '.stroke-\[10\%\]{stroke-width:10%;}'],
            ['stroke-[.5]', '.stroke-\[\.5\]{stroke-width:.5;}'],
            ['stroke-[-2px]', '.stroke-\[-2px\]{stroke-width:-2px;}'],
            ['stroke-[calc(100%+1px)]', '.stroke-\[calc\(100\%\+1px\)\]{stroke-width:calc(100%+1px);}'],
        ];
    }

    #[DataProvider('edgeCaseStrokeWidthClassProvider')]
    public function testEdgeCaseStrokeWidthClass(string $input, string $expected): void
    {
        $strokeWidthClass = StrokeWidthClass::parse($input);
        $this->assertInstanceOf(StrokeWidthClass::class, $strokeWidthClass);
        $this->assertSame($expected, $strokeWidthClass->toCss());
    }

    public static function edgeCaseStrokeWidthClassProvider(): array
    {
        return [
            ['stroke-[0]', '.stroke-\[0\]{stroke-width:0;}'],
            ['stroke-[1]', '.stroke-\[1\]{stroke-width:1;}'],
            ['stroke-[2]', '.stroke-\[2\]{stroke-width:2;}'],
            ['stroke-[3]', '.stroke-\[3\]{stroke-width:3;}'],
            ['stroke-[0.01]', '.stroke-\[0\.01\]{stroke-width:0.01;}'],
            ['stroke-[99999px]', '.stroke-\[99999px\]{stroke-width:99999px;}'],
        ];
    }

    // public function testStrokeWidthClassCaseInsensitivity(): void
    // {
    //     $lowerCaseClass = StrokeWidthClass::parse('stroke-[10PX]');
    //     $upperCaseClass = StrokeWidthClass::parse('stroke-[10px]');

    //     $this->assertInstanceOf(StrokeWidthClass::class, $lowerCaseClass);
    //     $this->assertInstanceOf(StrokeWidthClass::class, $upperCaseClass);
    //     $this->assertSame($lowerCaseClass->toCss(), $upperCaseClass->toCss());
    // }
}
