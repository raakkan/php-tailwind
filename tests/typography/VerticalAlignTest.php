<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\VerticalAlignClass;
use PHPUnit\Framework\Attributes\DataProvider;

class VerticalAlignTest extends TestCase
{
    #[DataProvider('standardVerticalAlignProvider')]
    public function testStandardVerticalAlignClass(string $input, string $expected): void
    {
        $verticalAlignClass = VerticalAlignClass::parse($input);
        $this->assertInstanceOf(VerticalAlignClass::class, $verticalAlignClass);
        $this->assertSame($expected, $verticalAlignClass->toCss());
    }

    public static function standardVerticalAlignProvider(): array
    {
        return [
            ['align-baseline', '.align-baseline{vertical-align:baseline;}'],
            ['align-top', '.align-top{vertical-align:top;}'],
            ['align-middle', '.align-middle{vertical-align:middle;}'],
            ['align-bottom', '.align-bottom{vertical-align:bottom;}'],
            ['align-text-top', '.align-text-top{vertical-align:text-top;}'],
            ['align-text-bottom', '.align-text-bottom{vertical-align:text-bottom;}'],
            ['align-sub', '.align-sub{vertical-align:sub;}'],
            ['align-super', '.align-super{vertical-align:super;}'],
        ];
    }

    #[DataProvider('arbitraryVerticalAlignProvider')]
    public function testArbitraryVerticalAlignClass(string $input, string $expected): void
    {
        $verticalAlignClass = VerticalAlignClass::parse($input);
        $this->assertInstanceOf(VerticalAlignClass::class, $verticalAlignClass);
        $this->assertSame($expected, $verticalAlignClass->toCss());
    }

    public static function arbitraryVerticalAlignProvider(): array
    {
        return [
            ['align-[4px]', '.align-\[4px\]{vertical-align:4px;}'],
            ['align-[10%]', '.align-\[10\%\]{vertical-align:10%;}'],
            ['align-[2em]', '.align-\[2em\]{vertical-align:2em;}'],
            ['align-[0.5rem]', '.align-\[0\.5rem\]{vertical-align:0.5rem;}'],
            // ['align-[calc(100%-20px)]', '.align-\[calc\(100\%-20px\)\]{vertical-align:calc(100%-20px);}'],
        ];
    }

    #[DataProvider('invalidVerticalAlignProvider')]
    public function testInvalidVerticalAlignClass(string $input): void
    {
        $verticalAlignClass = VerticalAlignClass::parse($input);
        $this->assertNull($verticalAlignClass);
    }

    public static function invalidVerticalAlignProvider(): array
    {
        return [
            ['align-invalid'],
            ['align-center'],
            ['vertical-middle'],
            // ['align-[invalid]'],
            // ['align-[10px20px]'],
        ];
    }

    #[DataProvider('edgeCaseVerticalAlignProvider')]
    public function testEdgeCaseVerticalAlignClass(string $input, string $expected): void
    {
        $verticalAlignClass = VerticalAlignClass::parse($input);
        $this->assertInstanceOf(VerticalAlignClass::class, $verticalAlignClass);
        $this->assertSame($expected, $verticalAlignClass->toCss());
    }

    public static function edgeCaseVerticalAlignProvider(): array
    {
        return [
            // ['align-[0]', '.align-\[0\]{vertical-align:0;}'],
            ['align-[auto]', '.align-\[auto\]{vertical-align:auto;}'],
            ['align-[inherit]', '.align-\[inherit\]{vertical-align:inherit;}'],
            ['align-[initial]', '.align-\[initial\]{vertical-align:initial;}'],
            ['align-[unset]', '.align-\[unset\]{vertical-align:unset;}'],
        ];
    }

    #[DataProvider('specialCharactersVerticalAlignProvider')]
    public function testSpecialCharactersVerticalAlignClass(string $input, string $expected): void
    {
        $verticalAlignClass = VerticalAlignClass::parse($input);
        $this->assertInstanceOf(VerticalAlignClass::class, $verticalAlignClass);
        $this->assertSame($expected, $verticalAlignClass->toCss());
    }

    public static function specialCharactersVerticalAlignProvider(): array
    {
        return [
            // ['align-[5px!important]', '.align-\[5px\!important\]{vertical-align:5px!important;}'],
            ['align-[calc(50%+10px)]', '.align-\[calc\(50\%\+10px\)\]{vertical-align:calc(50%+10px);}'],
        ];
    }

    // public function testEmptyArbitraryValue(): void
    // {
    //     $verticalAlignClass = VerticalAlignClass::parse('align-[]');
    //     $this->assertInstanceOf(VerticalAlignClass::class, $verticalAlignClass);
    //     $this->assertSame('', $verticalAlignClass->toCss());
    // }

    // public function testCaseInsensitivity(): void
    // {
    //     $lowerCase = VerticalAlignClass::parse('align-baseline');
    //     $upperCase = VerticalAlignClass::parse('ALIGN-BASELINE');
    //     $mixedCase = VerticalAlignClass::parse('Align-BaseLine');

    //     // $this->assertSame($lowerCase->toCss(), $upperCase->toCss());
    //     $this->assertSame($lowerCase->toCss(), $mixedCase->toCss());
    // }
}