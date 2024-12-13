<?php

namespace Raakkan\PhpTailwind\Tests\Interactivity;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Interactivity\CaretColorClass;

class CaretColorTest extends TestCase
{
    #[DataProvider('standardCaretColorProvider')]
    public function test_standard_caret_colors(string $input, string $expected): void
    {
        $caretColorClass = CaretColorClass::parse($input);
        $this->assertInstanceOf(CaretColorClass::class, $caretColorClass);
        $this->assertSame($expected, $caretColorClass->toCss());
    }

    public static function standardCaretColorProvider(): array
    {
        return [
            ['caret-red-500', '.caret-red-500 {caret-color: #ef4444;}'],
            ['caret-blue-300', '.caret-blue-300 {caret-color: #93c5fd;}'],
            ['caret-green-700', '.caret-green-700 {caret-color: #15803d;}'],
            ['caret-indigo-500', '.caret-indigo-500 {caret-color: #6366f1;}'],
            ['caret-black', '.caret-black {caret-color: #000000;}'],
            ['caret-white', '.caret-white {caret-color: #ffffff;}'],
            ['caret-slate-700', '.caret-slate-700 {caret-color: #334155;}'],
        ];
    }

    #[DataProvider('opacityProvider')]
    public function test_opacity(string $input, string $expected): void
    {
        $caretColorClass = CaretColorClass::parse($input);
        $this->assertInstanceOf(CaretColorClass::class, $caretColorClass);
        $this->assertSame($expected, $caretColorClass->toCss());
    }

    public static function opacityProvider(): array
    {
        return [
            ['caret-red-500/50', ".caret-red-500\/50 {caret-color: rgb(239 68 68 / 0.5);}"],
            ['caret-blue-300/75', ".caret-blue-300\/75 {caret-color: rgb(147 197 253 / 0.75);}"],
            ['caret-green-700/25', ".caret-green-700\/25 {caret-color: rgb(21 128 61 / 0.25);}"],
            ['caret-indigo-500/100', ".caret-indigo-500\/100 {caret-color: rgb(99 102 241 / 1);}"],
            ['caret-purple-100/50', ".caret-purple-100\/50 {caret-color: rgb(243 232 255 / 0.5);}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function test_arbitrary_values(string $input, string $expected): void
    {
        $caretColorClass = CaretColorClass::parse($input);
        $this->assertInstanceOf(CaretColorClass::class, $caretColorClass);
        $this->assertSame($expected, $caretColorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['caret-[#1da1f2]', '.caret-\\[\\#1da1f2\\] {caret-color: #1da1f2;}'],
            ['caret-[#50d71e]', '.caret-\\[\\#50d71e\\] {caret-color: #50d71e;}'],
            ['caret-[rgb(255,0,0)]', '.caret-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {caret-color: rgb(255,0,0);}'],
            ['caret-[hsl(200,100%,50%)]', '.caret-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\] {caret-color: hsl(200,100%,50%);}'],
            ['caret-[rgba(255,0,0,0.5)]', '.caret-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {caret-color: rgba(255,0,0,0.5);}'],
        ];
    }

    #[DataProvider('specialColorProvider')]
    public function test_special_colors(string $input, string $expected): void
    {
        $caretColorClass = CaretColorClass::parse($input);
        $this->assertInstanceOf(CaretColorClass::class, $caretColorClass);
        $this->assertSame($expected, $caretColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['caret-inherit', '.caret-inherit {caret-color: inherit;}'],
            ['caret-current', '.caret-current {caret-color: currentColor;}'],
            ['caret-transparent', '.caret-transparent {caret-color: transparent;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function test_invalid_inputs(string $input): void
    {
        $caretColorClass = CaretColorClass::parse($input);
        $this->assertNull($caretColorClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['caret-invalid-color'],
            ['caret-blue-1000'],
            ['caret-red-500/invalid'],
            ['bg-red-500'], // Should not parse background classes
            ['text-blue-300'], // Should not parse text color classes
            ['accent-red-500'], // Should not parse accent color classes
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function test_edge_cases(string $input, string $expected): void
    {
        $caretColorClass = CaretColorClass::parse($input);
        $this->assertInstanceOf(CaretColorClass::class, $caretColorClass);
        $this->assertSame($expected, $caretColorClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['caret-[#f00]', '.caret-\\[\\#f00\\] {caret-color: #f00;}'],
            ['caret-[#ff0000]', '.caret-\\[\\#ff0000\\] {caret-color: #ff0000;}'],
            ['caret-[rgb(255,0,0)]', '.caret-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {caret-color: rgb(255,0,0);}'],
            ['caret-[rgba(255,0,0,0.5)]', '.caret-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {caret-color: rgba(255,0,0,0.5);}'],
            ['caret-[hsl(0,100%,50%)]', '.caret-\\[hsl\\(0\\2c 100\\%\\2c 50\\%\\)\\] {caret-color: hsl(0,100%,50%);}'],
            ['caret-[hsla(0,100%,50%,0.5)]', '.caret-\\[hsla\\(0\\2c 100\\%\\2c 50\\%\\2c 0\\.5\\)\\] {caret-color: hsla(0,100%,50%,0.5);}'],
            ['caret-slate-50', '.caret-slate-50 {caret-color: #f8fafc;}'],
            ['caret-rose-950', '.caret-rose-950 {caret-color: #4c0519;}'],
        ];
    }
}
