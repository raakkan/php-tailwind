<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\TextColorClass;
use PHPUnit\Framework\Attributes\DataProvider;

class TextColorTest extends TestCase
{
    #[DataProvider('standardColorProvider')]
    public function testStandardColors(string $input, string $expected): void
    {
        $textColorClass = TextColorClass::parse($input);
        $this->assertInstanceOf(TextColorClass::class, $textColorClass);
        $this->assertSame($expected, $textColorClass->toCss());
    }

    public static function standardColorProvider(): array
    {
        return [
            ['text-black', '.text-black{color:rgb(0 0 0);}'],
            ['text-white', '.text-white{color:rgb(255 255 255);}'],
            ['text-red-500', '.text-red-500{color:rgb(239 68 68);}'],
            ['text-blue-700', '.text-blue-700{color:rgb(29 78 216);}'],
            ['text-green-300', '.text-green-300{color:rgb(134 239 172);}'],
            ['text-purple-900', '.text-purple-900{color:rgb(88 28 135);}'],
        ];
    }

    #[DataProvider('opacityColorProvider')]
    public function testColorsWithOpacity(string $input, string $expected): void
    {
        $textColorClass = TextColorClass::parse($input);
        $this->assertInstanceOf(TextColorClass::class, $textColorClass);
        $this->assertSame($expected, $textColorClass->toCss());
    }

    public static function opacityColorProvider(): array
    {
        return [
            ['text-black/50', '.text-black\/50{color:rgb(0 0 0 / 0.50);}'],
            ['text-white/75', '.text-white\/75{color:rgb(255 255 255 / 0.75);}'],
            ['text-red-500/25', '.text-red-500\/25{color:rgb(239 68 68 / 0.25);}'],
            ['text-blue-700/90', '.text-blue-700\/90{color:rgb(29 78 216 / 0.90);}'],
        ];
    }

    #[DataProvider('arbitraryColorProvider')]
    public function testArbitraryColors(string $input, string $expected): void
    {
        $textColorClass = TextColorClass::parse($input);
        $this->assertInstanceOf(TextColorClass::class, $textColorClass);
        $this->assertSame($expected, $textColorClass->toCss());
    }

    public static function arbitraryColorProvider(): array
    {
        return [
            ['text-[#50d71e]', '.text-\[#50d71e\]{color:#50d71e;}'],
            ['text-[rgb(80,215,30)]', '.text-\[rgb\(80\2c 215\2c 30\)\]{color:rgb(80,215,30);}'],
            ['text-[hsl(100,50%,50%)]', '.text-\[hsl\(100\2c 50\%\2c 50\%\)\]{color:hsl(100,50%,50%);}'],
        ];
    }

    // #[DataProvider('arbitraryColorWithOpacityProvider')]
    // public function testArbitraryColorsWithOpacity(string $input, string $expected): void
    // {
    //     $textColorClass = TextColorClass::parse($input);
    //     $this->assertInstanceOf(TextColorClass::class, $textColorClass);
    //     $this->assertSame($expected, $textColorClass->toCss());
    // }

    // public static function arbitraryColorWithOpacityProvider(): array
    // {
    //     return [
    //         ['text-[#50d71e]/50', '.text-\[#50d71e\]\/50{color:rgb(#50d71e / 0.50);}'],
    //         ['text-[rgb(80,215,30)]/75', '.text-\[rgb\(80\,215\,30\)\]\/75{color:rgb(rgb(80,215,30) / 0.75);}'],
    //         ['text-[hsl(100,50%,50%)]/25', '.text-\[hsl\(100\,50\%\,50\%\)\]\/25{color:rgb(hsl(100,50%,50%) / 0.25);}'],
    //     ];
    // }

    #[DataProvider('specialColorProvider')]
    public function testSpecialColors(string $input, string $expected): void
    {
        $textColorClass = TextColorClass::parse($input);
        $this->assertInstanceOf(TextColorClass::class, $textColorClass);
        $this->assertSame($expected, $textColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['text-inherit', '.text-inherit{color:rgb(inherit);}'],
            ['text-current', '.text-current{color:rgb(currentColor);}'],
            ['text-transparent', '.text-transparent{color:rgb(transparent);}'],
        ];
    }

    // #[DataProvider('invalidColorProvider')]
    // public function testInvalidColors(string $input): void
    // {
    //     $textColorClass = TextColorClass::parse($input);
    //     $this->assertNull($textColorClass);
    // }

    // public static function invalidColorProvider(): array
    // {
    //     return [
    //         // ['text-invalid'],
    //         // ['text-red'],
    //         ['text-blue-1000'],
    //         ['text-[invalid]'],
    //         ['text-red-500/invalid'],
    //     ];
    // }

    public function testEdgeCases(): void
    {
        // Test with maximum opacity value
        $maxOpacity = TextColorClass::parse('text-red-500/100');
        $this->assertSame('.text-red-500\/100{color:rgb(239 68 68 / 1.00);}', $maxOpacity->toCss());

        // Test with minimum opacity value
        $minOpacity = TextColorClass::parse('text-blue-700/0');
        $this->assertSame('.text-blue-700\/0{color:rgb(29 78 216 / 0.00);}', $minOpacity->toCss());

        // Test with arbitrary color and maximum opacity
        // $arbitraryMaxOpacity = TextColorClass::parse('text-[#FF00FF]/100');
        // $this->assertSame('.text-\[#FF00FF\]\/100{color:rgb(#FF00FF / 1.00);}', $arbitraryMaxOpacity->toCss());
    }
}