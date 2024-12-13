<?php

namespace Raakkan\PhpTailwind\Tests\SVG;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\SVG\FillClass;

class FillTest extends TestCase
{
    #[DataProvider('standardFillColorProvider')]
    public function test_standard_fill_colors(string $input, string $expected): void
    {
        $fillClass = FillClass::parse($input);
        $this->assertInstanceOf(FillClass::class, $fillClass);
        $this->assertSame($expected, $fillClass->toCss());
    }

    public static function standardFillColorProvider(): array
    {
        return [
            ['fill-red-500', '.fill-red-500 {fill: #ef4444;}'],
            ['fill-blue-300', '.fill-blue-300 {fill: #93c5fd;}'],
            ['fill-green-700', '.fill-green-700 {fill: #15803d;}'],
            ['fill-indigo-500', '.fill-indigo-500 {fill: #6366f1;}'],
            ['fill-black', '.fill-black {fill: #000000;}'],
            ['fill-white', '.fill-white {fill: #ffffff;}'],
            ['fill-slate-700', '.fill-slate-700 {fill: #334155;}'],
            ['fill-slate-50', '.fill-slate-50 {fill: #f8fafc;}'],
            ['fill-rose-950', '.fill-rose-950 {fill: #4c0519;}'],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function test_arbitrary_values(string $input, string $expected): void
    {
        $fillClass = FillClass::parse($input);
        $this->assertInstanceOf(FillClass::class, $fillClass);
        $this->assertSame($expected, $fillClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['fill-[#1da1f2]', '.fill-\\[\\#1da1f2\\] {fill: #1da1f2;}'],
            ['fill-[#50d71e]', '.fill-\\[\\#50d71e\\] {fill: #50d71e;}'],
            ['fill-[rgb(255,0,0)]', '.fill-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {fill: rgb(255,0,0);}'],
            ['fill-[hsl(200,100%,50%)]', '.fill-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\] {fill: hsl(200,100%,50%);}'],
            ['fill-[rgba(255,0,0,0.5)]', '.fill-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {fill: rgba(255,0,0,0.5);}'],
        ];
    }

    #[DataProvider('specialValueProvider')]
    public function test_special_values(string $input, string $expected): void
    {
        $fillClass = FillClass::parse($input);
        $this->assertInstanceOf(FillClass::class, $fillClass);
        $this->assertSame($expected, $fillClass->toCss());
    }

    public static function specialValueProvider(): array
    {
        return [
            ['fill-inherit', '.fill-inherit {fill: inherit;}'],
            ['fill-current', '.fill-current {fill: currentColor;}'],
            ['fill-transparent', '.fill-transparent {fill: transparent;}'],
            ['fill-none', '.fill-none {fill: none;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function test_invalid_inputs(string $input): void
    {
        $fillClass = FillClass::parse($input);
        $this->assertNull($fillClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['fill-invalid-color'],
            ['fill-blue-1000'],
            ['fill-red-500/50'], // Opacity is not supported for fill
            ['bg-red-500'], // Should not parse background classes
            ['text-blue-300'], // Should not parse text color classes
            // ['fill-[invalid]'], // Invalid arbitrary value
            // ['fill-[rgb(300,0,0)]'], // Invalid RGB value
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function test_edge_cases(string $input, string $expected): void
    {
        $fillClass = FillClass::parse($input);
        $this->assertInstanceOf(FillClass::class, $fillClass);
        $this->assertSame($expected, $fillClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['fill-[#f00]', '.fill-\\[\\#f00\\] {fill: #f00;}'],
            ['fill-[#ff0000]', '.fill-\\[\\#ff0000\\] {fill: #ff0000;}'],
            ['fill-[rgb(255,0,0)]', '.fill-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {fill: rgb(255,0,0);}'],
            ['fill-[rgba(255,0,0,0.5)]', '.fill-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {fill: rgba(255,0,0,0.5);}'],
            ['fill-[hsl(0,100%,50%)]', '.fill-\\[hsl\\(0\\2c 100\\%\\2c 50\\%\\)\\] {fill: hsl(0,100%,50%);}'],
            ['fill-[hsla(0,100%,50%,0.5)]', '.fill-\\[hsla\\(0\\2c 100\\%\\2c 50\\%\\2c 0\\.5\\)\\] {fill: hsla(0,100%,50%,0.5);}'],
        ];
    }
}
