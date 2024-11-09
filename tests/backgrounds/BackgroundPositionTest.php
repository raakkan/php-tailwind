<?php

namespace Raakkan\PhpTailwind\Tests\Backgrounds;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Backgrounds\BackgroundPositionClass;

class BackgroundPositionTest extends TestCase
{
    #[DataProvider('backgroundPositionClassProvider')]
    public function testBackgroundPositionClass(string $input, string $expected): void
    {
        $bgPositionClass = BackgroundPositionClass::parse($input);
        $this->assertInstanceOf(BackgroundPositionClass::class, $bgPositionClass);
        $this->assertSame($expected, $bgPositionClass->toCss());
    }

    public static function backgroundPositionClassProvider(): array
    {
        return [
            // Predefined values
            ['bg-bottom', '.bg-bottom{background-position:bottom;}'],
            ['bg-center', '.bg-center{background-position:center;}'],
            ['bg-left', '.bg-left{background-position:left;}'],
            ['bg-left-bottom', '.bg-left-bottom{background-position:left bottom;}'],
            ['bg-left-top', '.bg-left-top{background-position:left top;}'],
            ['bg-right', '.bg-right{background-position:right;}'],
            ['bg-right-bottom', '.bg-right-bottom{background-position:right bottom;}'],
            ['bg-right-top', '.bg-right-top{background-position:right top;}'],
            ['bg-top', '.bg-top{background-position:top;}'],

            // Arbitrary values
            ['bg-[center]', '.bg-\[center\]{background-position:center;}'],
            ['bg-[top]', '.bg-\[top\]{background-position:top;}'],
            ['bg-[16px]', '.bg-\[16px\]{background-position:16px;}'],
            ['bg-[5rem]', '.bg-\[5rem\]{background-position:5rem;}'],
            ['bg-[50%]', '.bg-\[50\%\]{background-position:50%;}'],
            ['bg-[50%_25%]', '.bg-\[50\%_25\%\]{background-position:50% 25%;}'],
            ['bg-[top_right]', '.bg-\[top_right\]{background-position:top right;}'],
            ['bg-[25%_75%]', '.bg-\[25\%_75\%\]{background-position:25% 75%;}'],
            ['bg-[16px_32px]', '.bg-\[16px_32px\]{background-position:16px 32px;}'],
            ['bg-[0_0]', '.bg-\[0_0\]{background-position:0 0;}'],
            ['bg-[100%_100%]', '.bg-\[100\%_100\%\]{background-position:100% 100%;}'],
            ['bg-[center_top]', '.bg-\[center_top\]{background-position:center top;}'],

            // Edge cases
            ['bg-[calc(100%_-_10px)_calc(100%_-_20px)]', '.bg-\[calc\(100\%_-_10px\)_calc\(100\%_-_20px\)\]{background-position:calc(100% - 10px) calc(100% - 20px);}'],
            ['bg-[var(--position)]', '.bg-\[var\(--position\)\]{background-position:var(--position);}'],
        ];
    }

    public function testInvalidBackgroundPositionClass(): void
    {
        $this->assertNull(BackgroundPositionClass::parse('invalid-class'));
    }

    // #[DataProvider('invalidBackgroundPositionProvider')]
    // public function testInvalidBackgroundPosition(string $input): void
    // {
    //     $bgPositionClass = BackgroundPositionClass::parse($input);
    //     $this->assertInstanceOf(BackgroundPositionClass::class, $bgPositionClass);
    //     $this->assertSame('', $bgPositionClass->toCss());
    // }

    // public static function invalidBackgroundPositionProvider(): array
    // {
    //     return [
    //         ['bg-invalid'],
    //         ['bg-123'],
    //         ['bg-top-left'], // This is not a valid Tailwind class
    //         ['bg-[invalid]'],
    //         ['bg-[top left]'], // Space should be underscore
    //         ['bg-[50% 50%]'], // Space should be underscore
    //     ];
    // }

    #[DataProvider('escapedArbitraryValueProvider')]
    public function testEscapedArbitraryValue(string $input, string $expected): void
    {
        $bgPositionClass = BackgroundPositionClass::parse($input);
        $this->assertInstanceOf(BackgroundPositionClass::class, $bgPositionClass);
        $this->assertSame($expected, $bgPositionClass->toCss());
    }

    public static function escapedArbitraryValueProvider(): array
    {
        return [
            ['bg-[10px_20px]', '.bg-\[10px_20px\]{background-position:10px 20px;}'],
            ['bg-[2rem_50%]', '.bg-\[2rem_50\%\]{background-position:2rem 50%;}'],
            ['bg-[calc(100%_-_20px)]', '.bg-\[calc\(100\%_-_20px\)\]{background-position:calc(100% - 20px);}'],
        ];
    }
}
