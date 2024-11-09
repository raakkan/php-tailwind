<?php

namespace Raakkan\PhpTailwind\Tests\Backgrounds;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Backgrounds\BackgroundSizeClass;

class BackgroundSizeTest extends TestCase
{
    #[DataProvider('backgroundSizeClassProvider')]
    public function testBackgroundSizeClass(string $input, string $expected): void
    {
        $bgSizeClass = BackgroundSizeClass::parse($input);
        $this->assertInstanceOf(BackgroundSizeClass::class, $bgSizeClass);
        $this->assertSame($expected, $bgSizeClass->toCss());
    }

    public static function backgroundSizeClassProvider(): array
    {
        return [
            // Predefined values
            ['bg-auto', '.bg-auto{background-size:auto;}'],
            ['bg-cover', '.bg-cover{background-size:cover;}'],
            ['bg-contain', '.bg-contain{background-size:contain;}'],

            // Arbitrary values
            ['bg-[auto]', '.bg-\[auto\]{background-size:auto;}'],
            ['bg-[cover]', '.bg-\[cover\]{background-size:cover;}'],
            ['bg-[contain]', '.bg-\[contain\]{background-size:contain;}'],
            ['bg-[16px]', '.bg-\[16px\]{background-size:16px;}'],
            ['bg-[5rem]', '.bg-\[5rem\]{background-size:5rem;}'],
            ['bg-[50%]', '.bg-\[50\%\]{background-size:50%;}'],
            ['bg-[50%_25%]', '.bg-\[50\%_25\%\]{background-size:50% 25%;}'],
            ['bg-[100px_200px]', '.bg-\[100px_200px\]{background-size:100px 200px;}'],
            ['bg-[10vw_20vh]', '.bg-\[10vw_20vh\]{background-size:10vw 20vh;}'],
            ['bg-[2rem_50%]', '.bg-\[2rem_50\%\]{background-size:2rem 50%;}'],

            // Edge cases
            ['bg-[calc(100%_-_20px)]', '.bg-\[calc\(100\%_-_20px\)\]{background-size:calc(100% - 20px);}'],
            ['bg-[var(--bg-size)]', '.bg-\[var\(--bg-size\)\]{background-size:var(--bg-size);}'],
        ];
    }

    public function testInvalidBackgroundSizeClass(): void
    {
        $this->assertNull(BackgroundSizeClass::parse('invalid-class'));
    }

    // #[DataProvider('invalidBackgroundSizeProvider')]
    // public function testInvalidBackgroundSize(string $input): void
    // {
    //     $bgSizeClass = BackgroundSizeClass::parse($input);
    //     $this->assertInstanceOf(BackgroundSizeClass::class, $bgSizeClass);
    //     $this->assertSame('', $bgSizeClass->toCss());
    // }

    // public static function invalidBackgroundSizeProvider(): array
    // {
    //     return [
    //         ['bg-invalid'],
    //         ['bg-123'],
    //         ['bg-partial'],
    //         ['bg-[invalid]'],
    //         ['bg-[50% 50%]'], // Space should be underscore
    //         ['bg-[10px 20px]'], // Space should be underscore
    //     ];
    // }

    #[DataProvider('escapedArbitraryValueProvider')]
    public function testEscapedArbitraryValue(string $input, string $expected): void
    {
        $bgSizeClass = BackgroundSizeClass::parse($input);
        $this->assertInstanceOf(BackgroundSizeClass::class, $bgSizeClass);
        $this->assertSame($expected, $bgSizeClass->toCss());
    }

    public static function escapedArbitraryValueProvider(): array
    {
        return [
            ['bg-[10px_20px]', '.bg-\[10px_20px\]{background-size:10px 20px;}'],
            ['bg-[2rem_50%]', '.bg-\[2rem_50\%\]{background-size:2rem 50%;}'],
            ['bg-[calc(100%_-_20px)]', '.bg-\[calc\(100\%_-_20px\)\]{background-size:calc(100% - 20px);}'],
            // ['bg-[100%_!important]', '.bg-\[100\%_\!important\]{background-size:100% !important;}'],
        ];
    }
}
