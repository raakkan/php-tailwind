<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\TextIndentClass;
use PHPUnit\Framework\Attributes\DataProvider;

class TextIndentTest extends TestCase
{
    #[DataProvider('textIndentClassProvider')]
    public function testTextIndentClass(string $input, string $expected): void
    {
        $textIndentClass = TextIndentClass::parse($input);
        $this->assertInstanceOf(TextIndentClass::class, $textIndentClass);
        $this->assertSame($expected, $textIndentClass->toCss());
    }

    public static function textIndentClassProvider(): array
    {
        return [
            // Predefined indents
            ['indent-0', '.indent-0{text-indent:0px;}'],
            ['indent-px', '.indent-px{text-indent:1px;}'],
            ['indent-0.5', '.indent-0.5{text-indent:0.125rem;}'],
            ['indent-1', '.indent-1{text-indent:0.25rem;}'],
            ['indent-2', '.indent-2{text-indent:0.5rem;}'],
            ['indent-4', '.indent-4{text-indent:1rem;}'],
            ['indent-8', '.indent-8{text-indent:2rem;}'],
            ['indent-16', '.indent-16{text-indent:4rem;}'],
            ['indent-24', '.indent-24{text-indent:6rem;}'],
            ['indent-48', '.indent-48{text-indent:12rem;}'],
            ['indent-96', '.indent-96{text-indent:24rem;}'],

            // Arbitrary values
            ['indent-[2px]', '.indent-\[2px\]{text-indent:2px;}'],
            ['indent-[0.5em]', '.indent-\[0\.5em\]{text-indent:0.5em;}'],
            ['indent-[3rem]', '.indent-\[3rem\]{text-indent:3rem;}'],
            ['indent-[5%]', '.indent-\[5\%\]{text-indent:5%;}'],
            ['indent-[-2rem]', '.indent-\[-2rem\]{text-indent:-2rem;}'],
        ];
    }

    public function testInvalidTextIndentClass(): void
    {
        $this->assertNull(TextIndentClass::parse('indent-invalid'));
    }

    public function testTextIndentClassWithInvalidValue(): void
    {
        $textIndentClass = TextIndentClass::parse('indent-100');
        $this->assertNull($textIndentClass);
    }

    #[DataProvider('invalidArbitraryTextIndentProvider')]
    public function testInvalidArbitraryTextIndent(string $input): void
    {
        $textIndentClass = TextIndentClass::parse($input);
        $this->assertInstanceOf(TextIndentClass::class, $textIndentClass);
        $this->assertSame('', $textIndentClass->toCss());
    }

    public static function invalidArbitraryTextIndentProvider(): array
    {
        return [
            ['indent-[invalid]'],
            ['indent-[10]'], // Missing unit
            ['indent-[abc]'],
        ];
    }

    #[DataProvider('validArbitraryTextIndentProvider')]
    public function testValidArbitraryTextIndent(string $input, string $expected): void
    {
        $textIndentClass = TextIndentClass::parse($input);
        $this->assertInstanceOf(TextIndentClass::class, $textIndentClass);
        $this->assertSame($expected, $textIndentClass->toCss());
    }

    public static function validArbitraryTextIndentProvider(): array
    {
        return [
            ['indent-[10px]', '.indent-\[10px\]{text-indent:10px;}'],
            ['indent-[2.5rem]', '.indent-\[2\.5rem\]{text-indent:2.5rem;}'],
            ['indent-[20%]', '.indent-\[20\%\]{text-indent:20%;}'],
            ['indent-[-15px]', '.indent-\[-15px\]{text-indent:-15px;}'],
            // ['indent-[calc(100%-20px)]', '.indent-\[calc\(100\%-20px\)\]{text-indent:calc(100%-20px);}'],
        ];
    }

    public function testDefaultToZeroIndent(): void
    {
        $textIndentClass = TextIndentClass::parse('indent-unknown');
        $this->assertNull($textIndentClass);
    }

    #[DataProvider('edgeCaseArbitraryTextIndentProvider')]
    public function testEdgeCaseArbitraryTextIndent(string $input, string $expected): void
    {
        $textIndentClass = TextIndentClass::parse($input);
        $this->assertInstanceOf(TextIndentClass::class, $textIndentClass);
        $this->assertSame($expected, $textIndentClass->toCss());
    }

    public static function edgeCaseArbitraryTextIndentProvider(): array
    {
        return [
            ['indent-[0.001em]', '.indent-\[0\.001em\]{text-indent:0.001em;}'],
            ['indent-[99.9vw]', '.indent-\[99\.9vw\]{text-indent:99.9vw;}'],
            // ['indent-[-0.5ch]', '.indent-\[-0\.5ch\]{text-indent:-0.5ch;}'],
        ];
    }

    // #[DataProvider('specialCharactersTextIndentProvider')]
    // public function testSpecialCharactersTextIndent(string $input, string $expected): void
    // {
    //     $textIndentClass = TextIndentClass::parse($input);
    //     $this->assertInstanceOf(TextIndentClass::class, $textIndentClass);
    //     $this->assertSame($expected, $textIndentClass->toCss());
    // }

    // public static function specialCharactersTextIndentProvider(): array
    // {
    //     return [
    //         ['indent-[5rem!important]', '.indent-\[5rem\!important\]{text-indent:5rem!important;}'],
    //         ['indent-[calc(1rem+5px)]', '.indent-\[calc\(1rem\+5px\)\]{text-indent:calc(1rem+5px);}'],
    //     ];
    // }
}