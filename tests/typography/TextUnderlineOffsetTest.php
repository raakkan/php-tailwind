<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\TextUnderlineOffsetClass;

class TextUnderlineOffsetTest extends TestCase
{
    #[DataProvider('textUnderlineOffsetClassProvider')]
    public function testTextUnderlineOffsetClass(string $input, string $expected): void
    {
        $textUnderlineOffsetClass = TextUnderlineOffsetClass::parse($input);
        $this->assertInstanceOf(TextUnderlineOffsetClass::class, $textUnderlineOffsetClass);
        $this->assertSame($expected, $textUnderlineOffsetClass->toCss());
    }

    public static function textUnderlineOffsetClassProvider(): array
    {
        return [
            // Predefined offsets
            ['underline-offset-auto', '.underline-offset-auto{text-underline-offset:auto;}'],
            ['underline-offset-0', '.underline-offset-0{text-underline-offset:0px;}'],
            ['underline-offset-1', '.underline-offset-1{text-underline-offset:1px;}'],
            ['underline-offset-2', '.underline-offset-2{text-underline-offset:2px;}'],
            ['underline-offset-4', '.underline-offset-4{text-underline-offset:4px;}'],
            ['underline-offset-8', '.underline-offset-8{text-underline-offset:8px;}'],

            // Arbitrary values
            ['underline-offset-[3px]', '.underline-offset-\[3px\]{text-underline-offset:3px;}'],
            ['underline-offset-[0.25em]', '.underline-offset-\[0\.25em\]{text-underline-offset:0.25em;}'],
            ['underline-offset-[3%]', '.underline-offset-\[3\%\]{text-underline-offset:3%;}'],
        ];
    }

    public function testInvalidTextUnderlineOffsetClass(): void
    {
        $this->assertNull(TextUnderlineOffsetClass::parse('underline-offset-invalid'));
    }

    public function testTextUnderlineOffsetClassWithInvalidValue(): void
    {
        $textUnderlineOffsetClass = TextUnderlineOffsetClass::parse('underline-offset-7');
        $this->assertNull($textUnderlineOffsetClass);
    }

    #[DataProvider('invalidArbitraryTextUnderlineOffsetProvider')]
    public function testInvalidArbitraryTextUnderlineOffset(string $input): void
    {
        $textUnderlineOffsetClass = TextUnderlineOffsetClass::parse($input);
        $this->assertInstanceOf(TextUnderlineOffsetClass::class, $textUnderlineOffsetClass);
        $this->assertSame('', $textUnderlineOffsetClass->toCss());
    }

    public static function invalidArbitraryTextUnderlineOffsetProvider(): array
    {
        return [
            ['underline-offset-[invalid]'],
            ['underline-offset-[10]'], // Missing unit
            ['underline-offset-[10px10px]'], // Invalid format
        ];
    }

    #[DataProvider('validArbitraryTextUnderlineOffsetProvider')]
    public function testValidArbitraryTextUnderlineOffset(string $input, string $expected): void
    {
        $textUnderlineOffsetClass = TextUnderlineOffsetClass::parse($input);
        $this->assertInstanceOf(TextUnderlineOffsetClass::class, $textUnderlineOffsetClass);
        $this->assertSame($expected, $textUnderlineOffsetClass->toCss());
    }

    public static function validArbitraryTextUnderlineOffsetProvider(): array
    {
        return [
            ['underline-offset-[10px]', '.underline-offset-\[10px\]{text-underline-offset:10px;}'],
            ['underline-offset-[0.5em]', '.underline-offset-\[0\.5em\]{text-underline-offset:0.5em;}'],
            ['underline-offset-[3rem]', '.underline-offset-\[3rem\]{text-underline-offset:3rem;}'],
            ['underline-offset-[25%]', '.underline-offset-\[25\%\]{text-underline-offset:25%;}'],
        ];
    }

    #[DataProvider('edgeCaseArbitraryTextUnderlineOffsetProvider')]
    public function testEdgeCaseArbitraryTextUnderlineOffset(string $input, string $expected): void
    {
        $textUnderlineOffsetClass = TextUnderlineOffsetClass::parse($input);
        $this->assertInstanceOf(TextUnderlineOffsetClass::class, $textUnderlineOffsetClass);
        $this->assertSame($expected, $textUnderlineOffsetClass->toCss());
    }

    public static function edgeCaseArbitraryTextUnderlineOffsetProvider(): array
    {
        return [
            ['underline-offset-[0.1px]', '.underline-offset-\[0\.1px\]{text-underline-offset:0.1px;}'],
            ['underline-offset-[100%]', '.underline-offset-\[100\%\]{text-underline-offset:100%;}'],
        ];
    }

    #[DataProvider('calcFunctionTextUnderlineOffsetProvider')]
    public function testCalcFunctionTextUnderlineOffset(string $input, string $expected): void
    {
        $textUnderlineOffsetClass = TextUnderlineOffsetClass::parse($input);
        $this->assertInstanceOf(TextUnderlineOffsetClass::class, $textUnderlineOffsetClass);
        $this->assertSame($expected, $textUnderlineOffsetClass->toCss());
    }

    public static function calcFunctionTextUnderlineOffsetProvider(): array
    {
        return [
            ['underline-offset-[calc(1px+2px)]', '.underline-offset-\[calc\(1px\+2px\)\]{text-underline-offset:calc(1px+2px);}'],
            // ['underline-offset-[calc(100%-1rem)]', '.underline-offset-\[calc\(100\%\-1rem\)\]{text-underline-offset:calc(100%-1rem);}'],
        ];
    }

    // #[DataProvider('specialCharactersTextUnderlineOffsetProvider')]
    // public function testSpecialCharactersTextUnderlineOffset(string $input, string $expected): void
    // {
    //     $textUnderlineOffsetClass = TextUnderlineOffsetClass::parse($input);
    //     $this->assertInstanceOf(TextUnderlineOffsetClass::class, $textUnderlineOffsetClass);
    //     $this->assertSame($expected, $textUnderlineOffsetClass->toCss());
    // }

    // public static function specialCharactersTextUnderlineOffsetProvider(): array
    // {
    //     return [
    //         ['underline-offset-[5px!important]', '.underline-offset-\[5px\!important\]{text-underline-offset:5px!important;}'],
    //         ['underline-offset-[var(--offset)]', '.underline-offset-\[var\(--offset\)\]{text-underline-offset:var(--offset);}'],
    //     ];
    // }
}
