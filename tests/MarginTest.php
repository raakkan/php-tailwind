<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Spacing\MarginClass;
use PHPUnit\Framework\Attributes\DataProvider;

class MarginTest extends TestCase
{
    #[DataProvider('marginClassProvider')]
    public function testMarginClass(string $input, string $expected): void
    {
        $marginClass = MarginClass::parse($input);
        $this->assertInstanceOf(MarginClass::class, $marginClass);
        $this->assertSame($expected, $marginClass->toCss());
    }

    public static function marginClassProvider(): array
    {
        return [
            ['m-0', '.m-0{margin:0px;}'],
            ['m-px', '.m-px{margin:1px;}'],
            ['m-0.5', '.m-0\.5{margin:0.125rem;}'],
            ['m-1', '.m-1{margin:0.25rem;}'],
            ['m-2', '.m-2{margin:0.5rem;}'],
            ['m-4', '.m-4{margin:1rem;}'],
            ['m-8', '.m-8{margin:2rem;}'],
            ['m-16', '.m-16{margin:4rem;}'],
            ['m-32', '.m-32{margin:8rem;}'],
            ['m-64', '.m-64{margin:16rem;}'],
            ['mt-4', '.mt-4{margin-top:1rem;}'],
            ['mr-4', '.mr-4{margin-right:1rem;}'],
            ['mb-4', '.mb-4{margin-bottom:1rem;}'],
            ['ml-4', '.ml-4{margin-left:1rem;}'],
            ['mx-4', '.mx-4{margin-left:1rem;margin-right:1rem;}'],
            ['my-4', '.my-4{margin-top:1rem;margin-bottom:1rem;}'],
            ['-m-4', '.-m-4{margin:-1rem;}'],
            ['-mt-4', '.-mt-4{margin-top:-1rem;}'],
            ['-mr-4', '.-mr-4{margin-right:-1rem;}'],
            ['-mb-4', '.-mb-4{margin-bottom:-1rem;}'],
            ['-ml-4', '.-ml-4{margin-left:-1rem;}'],
            ['-mx-4', '.-mx-4{margin-left:-1rem;margin-right:-1rem;}'],
            ['-my-4', '.-my-4{margin-top:-1rem;margin-bottom:-1rem;}'],
        ];
    }

    public function testInvalidMarginClass(): void
    {
        $this->assertNull(MarginClass::parse('invalid-class'));
    }

    public function testMarginClassWithInvalidValue(): void
    {
        $marginClass = MarginClass::parse('m-invalid');
        $this->assertInstanceOf(MarginClass::class, $marginClass);
        $this->assertSame('', $marginClass->toCss());
    }

    #[DataProvider('autoMarginClassProvider')]
    public function testAutoMarginClass(string $input, string $expected): void
    {
        $marginClass = MarginClass::parse($input);
        $this->assertInstanceOf(MarginClass::class, $marginClass);
        $this->assertSame($expected, $marginClass->toCss());
    }

    public static function autoMarginClassProvider(): array
    {
        return [
            ['m-auto', '.m-auto{margin:auto;}'],
            ['mt-auto', '.mt-auto{margin-top:auto;}'],
            ['mr-auto', '.mr-auto{margin-right:auto;}'],
            ['mb-auto', '.mb-auto{margin-bottom:auto;}'],
            ['ml-auto', '.ml-auto{margin-left:auto;}'],
            ['mx-auto', '.mx-auto{margin-left:auto;margin-right:auto;}'],
            ['my-auto', '.my-auto{margin-top:auto;margin-bottom:auto;}'],
        ];
    }

    #[DataProvider('inlineMarginClassProvider')]
    public function testInlineMarginClasses(string $input, string $expected): void
    {
        $marginClass = MarginClass::parse($input);
        $this->assertInstanceOf(MarginClass::class, $marginClass);
        $this->assertSame($expected, $marginClass->toCss());
    }

    public static function inlineMarginClassProvider(): array
    {
        return [
            ['ms-4', '.ms-4{margin-inline-start:1rem;}'],
            ['me-4', '.me-4{margin-inline-end:1rem;}'],
            ['-ms-4', '.-ms-4{margin-inline-start:-1rem;}'],
            ['-me-4', '.-me-4{margin-inline-end:-1rem;}'],
            ['ms-auto', '.ms-auto{margin-inline-start:auto;}'],
            ['me-auto', '.me-auto{margin-inline-end:auto;}'],
        ];
    }

    #[DataProvider('arbitraryMarginClassProvider')]
    public function testArbitraryMarginClass(string $input, string $expected): void
    {
        $marginClass = MarginClass::parse($input);
        $this->assertInstanceOf(MarginClass::class, $marginClass);
        $this->assertSame($expected, $marginClass->toCss());
    }

    public static function arbitraryMarginClassProvider(): array
    {
        return [
            ['m-[10px]', '.m-\[10px\]{margin:10px;}'],
            ['mt-[2em]', '.mt-\[2em\]{margin-top:2em;}'],
            ['mr-[10vh]', '.mr-\[10vh\]{margin-right:10vh;}'],
            ['mb-[10%]', '.mb-\[10\%\]{margin-bottom:10%;}'],
            ['mx-[10px]', '.mx-\[10px\]{margin-left:10px;margin-right:10px;}'],
            ['my-[2em]', '.my-\[2em\]{margin-top:2em;margin-bottom:2em;}'],
            ['-m-[10px]', '.-m-\[10px\]{margin:-10px;}'],
            ['-mt-[2em]', '.-mt-\[2em\]{margin-top:-2em;}'],
            ['ms-[10px]', '.ms-\[10px\]{margin-inline-start:10px;}'],
            ['me-[2em]', '.me-\[2em\]{margin-inline-end:2em;}'],
        ];
    }
}