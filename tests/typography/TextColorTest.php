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
            ['text-red-500', ".text-red-500 {--tw-text-opacity: 1;color: rgb(239 68 68 / var(--tw-text-opacity));}"],
            ['text-blue-300', ".text-blue-300 {--tw-text-opacity: 1;color: rgb(147 197 253 / var(--tw-text-opacity));}"],
            ['text-green-700', ".text-green-700 {--tw-text-opacity: 1;color: rgb(21 128 61 / var(--tw-text-opacity));}"],
            ['text-indigo-500', ".text-indigo-500 {--tw-text-opacity: 1;color: rgb(99 102 241 / var(--tw-text-opacity));}"],
            ['text-black', ".text-black {--tw-text-opacity: 1;color: rgb(0 0 0 / var(--tw-text-opacity));}"],
            ['text-white', ".text-white {--tw-text-opacity: 1;color: rgb(255 255 255 / var(--tw-text-opacity));}"],
            ['text-slate-700', ".text-slate-700 {--tw-text-opacity: 1;color: rgb(51 65 85 / var(--tw-text-opacity));}"],
        ];
    }

    #[DataProvider('opacityProvider')]
    public function testOpacity(string $input, string $expected): void
    {
        $textColorClass = TextColorClass::parse($input);
        $this->assertInstanceOf(TextColorClass::class, $textColorClass);
        $this->assertSame($expected, $textColorClass->toCss());
    }

    public static function opacityProvider(): array
    {
        return [
            ['text-red-500/50', ".text-red-500\/50 {color: rgb(239 68 68 / 0.5);}"],
            ['text-blue-300/75', ".text-blue-300\/75 {color: rgb(147 197 253 / 0.75);}"],
            ['text-green-700/25', ".text-green-700\/25 {color: rgb(21 128 61 / 0.25);}"],
            ['text-indigo-500/100', ".text-indigo-500\/100 {color: rgb(99 102 241 / 1);}"],
            ['text-purple-100/50', ".text-purple-100\/50 {color: rgb(243 232 255 / 0.5);}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function testArbitraryValues(string $input, string $expected): void
    {
        $textColorClass = TextColorClass::parse($input);
        $this->assertInstanceOf(TextColorClass::class, $textColorClass);
        $this->assertSame($expected, $textColorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['text-[#1da1f2]', ".text-\\[\\#1da1f2\\] {--tw-text-opacity: 1;color: #1da1f2;}"],
            ['text-[#50d71e]', ".text-\\[\\#50d71e\\] {--tw-text-opacity: 1;color: #50d71e;}"],
            ['text-[rgb(255,0,0)]', ".text-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {--tw-text-opacity: 1;color: rgb(255,0,0);}"],
            ['text-[hsl(200,100%,50%)]', ".text-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\] {--tw-text-opacity: 1;color: hsl(200,100%,50%);}"],
            ['text-[rgba(255,0,0,0.5)]', ".text-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {--tw-text-opacity: 1;color: rgba(255,0,0,0.5);}"],
        ];
    }

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
            ['text-inherit', '.text-inherit {--tw-text-opacity: 1;color: inherit;}'],
            ['text-current', '.text-current {--tw-text-opacity: 1;color: currentColor;}'],
            ['text-transparent', '.text-transparent {--tw-text-opacity: 1;color: transparent;}'],
        ];
    }

    #[DataProvider('invalidColorProvider')]
    public function testInvalidColors(string $input): void
    {
        $textColorClass = TextColorClass::parse($input);
        $this->assertNull($textColorClass);
    }

    public static function invalidColorProvider(): array
    {
        return [
            ['text-invalid'],
            ['text-blue-1000'],
            ['text-red-500/invalid'],
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function testEdgeCases(string $input, string $expected): void
    {
        $textColorClass = TextColorClass::parse($input);
        $this->assertInstanceOf(TextColorClass::class, $textColorClass);
        $this->assertSame($expected, $textColorClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['text-[#f00]', ".text-\\[\\#f00\\] {--tw-text-opacity: 1;color: #f00;}"],
            ['text-[#ff0000]', ".text-\\[\\#ff0000\\] {--tw-text-opacity: 1;color: #ff0000;}"],
            ['text-[rgb(255,0,0)]', ".text-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {--tw-text-opacity: 1;color: rgb(255,0,0);}"],
            ['text-[rgba(255,0,0,0.5)]', ".text-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {--tw-text-opacity: 1;color: rgba(255,0,0,0.5);}"],
            ['text-[hsl(0,100%,50%)]', ".text-\\[hsl\\(0\\2c 100\\%\\2c 50\\%\\)\\] {--tw-text-opacity: 1;color: hsl(0,100%,50%);}"],
            ['text-[hsla(0,100%,50%,0.5)]', ".text-\\[hsla\\(0\\2c 100\\%\\2c 50\\%\\2c 0\\.5\\)\\] {--tw-text-opacity: 1;color: hsla(0,100%,50%,0.5);}"],
            ['text-slate-50', ".text-slate-50 {--tw-text-opacity: 1;color: rgb(248 250 252 / var(--tw-text-opacity));}"],
            ['text-rose-950', ".text-rose-950 {--tw-text-opacity: 1;color: rgb(76 5 25 / var(--tw-text-opacity));}"],
        ];
    }
}