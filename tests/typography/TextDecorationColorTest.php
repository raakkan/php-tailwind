<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\TextDecorationColorClass;
use PHPUnit\Framework\Attributes\DataProvider;

class TextDecorationColorTest extends TestCase
{
    #[DataProvider('standardColorProvider')]
    public function testStandardColors(string $input, string $expected): void
    {
        $textDecorationColorClass = TextDecorationColorClass::parse($input);
        $this->assertInstanceOf(TextDecorationColorClass::class, $textDecorationColorClass);
        $this->assertSame($expected, $textDecorationColorClass->toCss());
    }

    public static function standardColorProvider(): array
    {
        return [
            ['decoration-inherit', '.decoration-inherit{text-decoration-color:inherit;}'],
            ['decoration-current', '.decoration-current{text-decoration-color:currentColor;}'],
            ['decoration-transparent', '.decoration-transparent{text-decoration-color:transparent;}'],
            ['decoration-black', '.decoration-black{text-decoration-color:#000000;}'],
            ['decoration-white', '.decoration-white{text-decoration-color:#ffffff;}'],
            ['decoration-red-500', '.decoration-red-500{text-decoration-color:#ef4444;}'],
            ['decoration-blue-700', '.decoration-blue-700{text-decoration-color:#1d4ed8;}'],
            ['decoration-green-300', '.decoration-green-300{text-decoration-color:#86efac;}'],
            ['decoration-purple-900', '.decoration-purple-900{text-decoration-color:#581c87;}'],
        ];
    }

    #[DataProvider('arbitraryColorProvider')]
    public function testArbitraryColors(string $input, string $expected): void
    {
        $textDecorationColorClass = TextDecorationColorClass::parse($input);
        $this->assertInstanceOf(TextDecorationColorClass::class, $textDecorationColorClass);
        $this->assertSame($expected, $textDecorationColorClass->toCss());
    }

    public static function arbitraryColorProvider(): array
    {
        return [
            ['decoration-[#50d71e]', '.decoration-\[\#50d71e\]{text-decoration-color:#50d71e;}'],
            ['decoration-[rgb(80,215,30)]', '.decoration-\[rgb\(80\,215\,30\)\]{text-decoration-color:rgb(80,215,30);}'],
            ['decoration-[hsl(100,50%,50%)]', '.decoration-\[hsl\(100\,50\%\,50\%\)\]{text-decoration-color:hsl(100,50%,50%);}'],
            ['decoration-[rgba(80,215,30,0.5)]', '.decoration-\[rgba\(80\,215\,30\,0\.5\)\]{text-decoration-color:rgba(80,215,30,0.5);}'],
        ];
    }

    #[DataProvider('invalidColorProvider')]
    public function testInvalidColors(string $input): void
    {
        $textDecorationColorClass = TextDecorationColorClass::parse($input);
        $this->assertNull($textDecorationColorClass);
    }

    public static function invalidColorProvider(): array
    {
        return [
            ['decoration-invalid'],
            // ['decoration-red'],
            ['decoration-blue-1000'],
            // ['decoration-[invalid]'],
            ['text-red-500'], // Should not parse 'text-' classes
        ];
    }

    public function testEdgeCases(): void
    {
        // Test with color at the edge of the spectrum
        $edgeColor = TextDecorationColorClass::parse('decoration-slate-950');
        $this->assertSame('.decoration-slate-950{text-decoration-color:#020617;}', $edgeColor->toCss());

        // Test with arbitrary color using all lowercase
        $lowercaseHex = TextDecorationColorClass::parse('decoration-[#abcdef]');
        $this->assertSame('.decoration-\[\#abcdef\]{text-decoration-color:#abcdef;}', $lowercaseHex->toCss());

        // Test with arbitrary color using all uppercase
        $uppercaseHex = TextDecorationColorClass::parse('decoration-[#ABCDEF]');
        $this->assertSame('.decoration-\[\#ABCDEF\]{text-decoration-color:#ABCDEF;}', $uppercaseHex->toCss());

        // Test with arbitrary color using mixed case
        $mixedCaseHex = TextDecorationColorClass::parse('decoration-[#aBcDeF]');
        $this->assertSame('.decoration-\[\#aBcDeF\]{text-decoration-color:#aBcDeF;}', $mixedCaseHex->toCss());

        // Test with arbitrary color using shorthand hex
        $shorthandHex = TextDecorationColorClass::parse('decoration-[#abc]');
        $this->assertSame('.decoration-\[\#abc\]{text-decoration-color:#abc;}', $shorthandHex->toCss());

        // Test with arbitrary color using rgba with decimals
        $rgbaDecimal = TextDecorationColorClass::parse('decoration-[rgba(80,215,30,0.5)]');
        $this->assertSame('.decoration-\[rgba\(80\,215\,30\,0\.5\)\]{text-decoration-color:rgba(80,215,30,0.5);}', $rgbaDecimal->toCss());

        // Test with arbitrary color using hsla
        $hsla = TextDecorationColorClass::parse('decoration-[hsla(100,50%,50%,0.5)]');
        $this->assertSame('.decoration-\[hsla\(100\,50\%\,50\%\,0\.5\)\]{text-decoration-color:hsla(100,50%,50%,0.5);}', $hsla->toCss());
    }

    public function testSpecialCases(): void
    {
        // Test 'inherit' value
        $inherit = TextDecorationColorClass::parse('decoration-inherit');
        $this->assertSame('.decoration-inherit{text-decoration-color:inherit;}', $inherit->toCss());

        // Test 'current' value
        $current = TextDecorationColorClass::parse('decoration-current');
        $this->assertSame('.decoration-current{text-decoration-color:currentColor;}', $current->toCss());

        // Test 'transparent' value
        $transparent = TextDecorationColorClass::parse('decoration-transparent');
        $this->assertSame('.decoration-transparent{text-decoration-color:transparent;}', $transparent->toCss());
    }
}