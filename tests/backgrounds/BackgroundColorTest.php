<?php

namespace Raakkan\PhpTailwind\Tests\Backgrounds;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Backgrounds\BackgroundColorClass;
use PHPUnit\Framework\Attributes\DataProvider;

class BackgroundColorTest extends TestCase
{
    #[DataProvider('standardColorProvider')]
    public function testStandardColors(string $input, string $expected): void
    {
        $bgColorClass = BackgroundColorClass::parse($input);
        $this->assertInstanceOf(BackgroundColorClass::class, $bgColorClass);
        $this->assertSame($expected, $bgColorClass->toCss());
    }

    public static function standardColorProvider(): array
    {
        return [
            ['bg-black', '.bg-black{--tw-bg-opacity:1;background-color:rgb(0 0 0 / var(--tw-bg-opacity));}'],
            ['bg-white', '.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity));}'],
            ['bg-red-500', '.bg-red-500{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity));}'],
            ['bg-blue-700', '.bg-blue-700{--tw-bg-opacity:1;background-color:rgb(29 78 216 / var(--tw-bg-opacity));}'],
            ['bg-green-300', '.bg-green-300{--tw-bg-opacity:1;background-color:rgb(134 239 172 / var(--tw-bg-opacity));}'],
            ['bg-purple-900', '.bg-purple-900{--tw-bg-opacity:1;background-color:rgb(88 28 135 / var(--tw-bg-opacity));}'],
        ];
    }

    #[DataProvider('opacityColorProvider')]
    public function testColorsWithOpacity(string $input, string $expected): void
    {
        $bgColorClass = BackgroundColorClass::parse($input);
        $this->assertInstanceOf(BackgroundColorClass::class, $bgColorClass);
        $this->assertSame($expected, $bgColorClass->toCss());
    }

    public static function opacityColorProvider(): array
    {
        return [
            ['bg-black/50', '.bg-black\/50{background-color:rgb(0 0 0 / 0.50);}'],
            ['bg-white/75', '.bg-white\/75{background-color:rgb(255 255 255 / 0.75);}'],
            ['bg-red-500/25', '.bg-red-500\/25{background-color:rgb(239 68 68 / 0.25);}'],
            ['bg-blue-700/90', '.bg-blue-700\/90{background-color:rgb(29 78 216 / 0.90);}'],
        ];
    }

    #[DataProvider('arbitraryColorProvider')]
    public function testArbitraryColors(string $input, string $expected): void
    {
        $bgColorClass = BackgroundColorClass::parse($input);
        $this->assertInstanceOf(BackgroundColorClass::class, $bgColorClass);
        $this->assertSame($expected, $bgColorClass->toCss());
    }

    public static function arbitraryColorProvider(): array
    {
        return [
            ['bg-[#50d71e]', '.bg-\[#50d71e\]{--tw-bg-opacity:1;background-color:#50d71e;}'],
            ['bg-[rgb(80,215,30)]', '.bg-\[rgb\(80\2c 215\2c 30\)\]{--tw-bg-opacity:1;background-color:rgb(80,215,30);}'],
            ['bg-[hsl(100,50%,50%)]', '.bg-\[hsl\(100\2c 50\%\2c 50\%\)\]{--tw-bg-opacity:1;background-color:hsl(100,50%,50%);}'],
        ];
    }

    // #[DataProvider('arbitraryColorWithOpacityProvider')]
    // public function testArbitraryColorsWithOpacity(string $input, string $expected): void
    // {
    //     $bgColorClass = BackgroundColorClass::parse($input);
    //     $this->assertInstanceOf(BackgroundColorClass::class, $bgColorClass);
    //     $this->assertSame($expected, $bgColorClass->toCss());
    // }

    // public static function arbitraryColorWithOpacityProvider(): array
    // {
    //     return [
    //         ['bg-[#50d71e]/50', '.bg-\[#50d71e\]\/50{background-color:rgb(80 215 30 / 0.50);}'],
    //         ['bg-[rgb(80,215,30)]/75', '.bg-\[rgb\(80\2c 215\2c 30\)\]\/75{background-color:rgb(80 215 30 / 0.75);}'],
    //         ['bg-[hsl(100,50%,50%)]/25', '.bg-\[hsl\(100\2c 50\%\2c 50\%\)\]\/25{background-color:rgb(106 191 64 / 0.25);}'],
    //     ];
    // }

    #[DataProvider('specialColorProvider')]
    public function testSpecialColors(string $input, string $expected): void
    {
        $bgColorClass = BackgroundColorClass::parse($input);
        $this->assertInstanceOf(BackgroundColorClass::class, $bgColorClass);
        $this->assertSame($expected, $bgColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['bg-inherit', '.bg-inherit{background-color:inherit;}'],
            ['bg-current', '.bg-current{background-color:currentColor;}'],
            ['bg-transparent', '.bg-transparent{background-color:transparent;}'],
        ];
    }

    // #[DataProvider('invalidColorProvider')]
    // public function testInvalidColors(string $input): void
    // {
    //     $bgColorClass = BackgroundColorClass::parse($input);
    //     $this->assertNull($bgColorClass);
    // }

    // public static function invalidColorProvider(): array
    // {
    //     return [
    //         ['bg-invalid'],
    //         ['bg-red'],
    //         ['bg-blue-1000'],
    //         ['bg-[invalid]'],
    //         ['bg-red-500/invalid'],
    //     ];
    // }

    // public function testEdgeCases(): void
    // {
    //     // Test with maximum opacity value
    //     $maxOpacity = BackgroundColorClass::parse('bg-red-500/100');
    //     $this->assertSame('.bg-red-500\/100{background-color:rgb(239 68 68 / 1.00);}', $maxOpacity->toCss());

    //     // Test with minimum opacity value
    //     $minOpacity = BackgroundColorClass::parse('bg-blue-700/0');
    //     $this->assertSame('.bg-blue-700\/0{background-color:rgb(29 78 216 / 0.00);}', $minOpacity->toCss());

    //     // Test with arbitrary color and maximum opacity
    //     $arbitraryMaxOpacity = BackgroundColorClass::parse('bg-[#FF00FF]/100');
    //     $this->assertSame('.bg-\[#FF00FF\]\/100{background-color:rgb(255 0 255 / 1.00);}', $arbitraryMaxOpacity->toCss());
    // }
}