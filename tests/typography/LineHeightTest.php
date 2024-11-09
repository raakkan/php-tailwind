<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\LineHeightClass;

class LineHeightTest extends TestCase
{
    #[DataProvider('lineHeightClassProvider')]
    public function testLineHeightClass(string $input, string $expected): void
    {
        $lineHeightClass = LineHeightClass::parse($input);
        $this->assertInstanceOf(LineHeightClass::class, $lineHeightClass);
        $this->assertSame($expected, $lineHeightClass->toCss());
    }

    public static function lineHeightClassProvider(): array
    {
        return [
            // Predefined numeric values
            ['leading-3', '.leading-3{line-height:.75rem;}'],
            ['leading-4', '.leading-4{line-height:1rem;}'],
            ['leading-5', '.leading-5{line-height:1.25rem;}'],
            ['leading-6', '.leading-6{line-height:1.5rem;}'],
            ['leading-7', '.leading-7{line-height:1.75rem;}'],
            ['leading-8', '.leading-8{line-height:2rem;}'],
            ['leading-9', '.leading-9{line-height:2.25rem;}'],
            ['leading-10', '.leading-10{line-height:2.5rem;}'],

            // Predefined named values
            ['leading-none', '.leading-none{line-height:1;}'],
            ['leading-tight', '.leading-tight{line-height:1.25;}'],
            ['leading-snug', '.leading-snug{line-height:1.375;}'],
            ['leading-normal', '.leading-normal{line-height:1.5;}'],
            ['leading-relaxed', '.leading-relaxed{line-height:1.625;}'],
            ['leading-loose', '.leading-loose{line-height:2;}'],

            // Arbitrary values
            ['leading-[3.5]', '.leading-\[3\.5\]{line-height:3.5;}'],
            ['leading-[3rem]', '.leading-\[3rem\]{line-height:3rem;}'],
            ['leading-[50px]', '.leading-\[50px\]{line-height:50px;}'],
            ['leading-[120%]', '.leading-\[120\%\]{line-height:120%;}'],
        ];
    }

    public function testInvalidLineHeightClass(): void
    {
        $this->assertNull(LineHeightClass::parse('leading-invalid'));
    }

    #[DataProvider('invalidArbitraryLineHeightProvider')]
    public function testInvalidArbitraryLineHeight(string $input): void
    {
        $lineHeightClass = LineHeightClass::parse($input);
        $this->assertInstanceOf(LineHeightClass::class, $lineHeightClass);
        $this->assertSame('', $lineHeightClass->toCss());
    }

    public static function invalidArbitraryLineHeightProvider(): array
    {
        return [
            ['leading-[invalid]'],
            ['leading-[abc]'],
            // ['leading-[]'],
        ];
    }

    #[DataProvider('edgeCaseArbitraryLineHeightProvider')]
    public function testEdgeCaseArbitraryLineHeight(string $input, string $expected): void
    {
        $lineHeightClass = LineHeightClass::parse($input);
        $this->assertInstanceOf(LineHeightClass::class, $lineHeightClass);
        $this->assertSame($expected, $lineHeightClass->toCss());
    }

    public static function edgeCaseArbitraryLineHeightProvider(): array
    {
        return [
            ['leading-[0]', '.leading-\[0\]{line-height:0;}'],
            ['leading-[1.5em]', '.leading-\[1\.5em\]{line-height:1.5em;}'],
            ['leading-[calc(1em+5px)]', '.leading-\[calc\(1em\+5px\)\]{line-height:calc(1em+5px);}'],
        ];
    }

    // #[DataProvider('specialCharactersLineHeightProvider')]
    // public function testSpecialCharactersLineHeight(string $input, string $expected): void
    // {
    //     $lineHeightClass = LineHeightClass::parse($input);
    //     $this->assertInstanceOf(LineHeightClass::class, $lineHeightClass);
    //     $this->assertSame($expected, $lineHeightClass->toCss());
    // }

    // public static function specialCharactersLineHeightProvider(): array
    // {
    //     return [
    //         ['leading-[2!important]', '.leading-\[2\!important\]{line-height:2!important;}'],
    //         ['leading-[var(--custom-line-height)]', '.leading-\[var\(--custom-line-height\)\]{line-height:var(--custom-line-height);}'],
    //     ];
    // }

    public function testDefaultToNormalLineHeight(): void
    {
        $lineHeightClass = LineHeightClass::parse('leading-unknown');
        $this->assertNull($lineHeightClass);
    }

    #[DataProvider('nonMatchingClassesProvider')]
    public function testNonMatchingClasses(string $input): void
    {
        $this->assertNull(LineHeightClass::parse($input));
    }

    public static function nonMatchingClassesProvider(): array
    {
        return [
            ['lead-3'],
            ['leading3'],
            ['leading-'],
            ['leading-extra-loose'],
            ['line-height-3'],
        ];
    }
}
