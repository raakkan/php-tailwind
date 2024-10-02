<?php

namespace Raakkan\PhpTailwind\Tests\SVG;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\SVG\StrokeClass;
use PHPUnit\Framework\Attributes\DataProvider;

class StrokeTest extends TestCase
{
    #[DataProvider('standardStrokeColorProvider')]
    public function testStandardStrokeColors(string $input, string $expected): void
    {
        $strokeClass = StrokeClass::parse($input);
        $this->assertInstanceOf(StrokeClass::class, $strokeClass);
        $this->assertSame($expected, $strokeClass->toCss());
    }

    public static function standardStrokeColorProvider(): array
    {
        return [
            ['stroke-red-500', ".stroke-red-500 {stroke: #ef4444;}"],
            ['stroke-blue-300', ".stroke-blue-300 {stroke: #93c5fd;}"],
            ['stroke-green-700', ".stroke-green-700 {stroke: #15803d;}"],
            ['stroke-indigo-500', ".stroke-indigo-500 {stroke: #6366f1;}"],
            ['stroke-black', ".stroke-black {stroke: #000000;}"],
            ['stroke-white', ".stroke-white {stroke: #ffffff;}"],
            ['stroke-slate-700', ".stroke-slate-700 {stroke: #334155;}"],
            ['stroke-slate-50', ".stroke-slate-50 {stroke: #f8fafc;}"],
            ['stroke-rose-950', ".stroke-rose-950 {stroke: #4c0519;}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function testArbitraryValues(string $input, string $expected): void
    {
        $strokeClass = StrokeClass::parse($input);
        $this->assertInstanceOf(StrokeClass::class, $strokeClass);
        $this->assertSame($expected, $strokeClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['stroke-[#1da1f2]', ".stroke-\\[\\#1da1f2\\] {stroke: #1da1f2;}"],
            ['stroke-[#50d71e]', ".stroke-\\[\\#50d71e\\] {stroke: #50d71e;}"],
            ['stroke-[rgb(255,0,0)]', ".stroke-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {stroke: rgb(255,0,0);}"],
            ['stroke-[hsl(200,100%,50%)]', ".stroke-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\] {stroke: hsl(200,100%,50%);}"],
            ['stroke-[rgba(255,0,0,0.5)]', ".stroke-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {stroke: rgba(255,0,0,0.5);}"],
        ];
    }

    #[DataProvider('specialValueProvider')]
    public function testSpecialValues(string $input, string $expected): void
    {
        $strokeClass = StrokeClass::parse($input);
        $this->assertInstanceOf(StrokeClass::class, $strokeClass);
        $this->assertSame($expected, $strokeClass->toCss());
    }

    public static function specialValueProvider(): array
    {
        return [
            ['stroke-inherit', ".stroke-inherit {stroke: inherit;}"],
            ['stroke-current', ".stroke-current {stroke: currentColor;}"],
            ['stroke-transparent', ".stroke-transparent {stroke: transparent;}"],
            ['stroke-none', ".stroke-none {stroke: none;}"],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $strokeClass = StrokeClass::parse($input);
        $this->assertNull($strokeClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['stroke-invalid-color'],
            ['stroke-blue-1000'],
            ['stroke-red-500/50'], // Opacity is not supported for stroke
            ['bg-red-500'], // Should not parse background classes
            ['text-blue-300'], // Should not parse text color classes
            ['fill-red-500'], // Should not parse fill classes
            // ['stroke-[invalid]'], // Invalid arbitrary value
            // ['stroke-[rgb(300,0,0)]'], // Invalid RGB value
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function testEdgeCases(string $input, string $expected): void
    {
        $strokeClass = StrokeClass::parse($input);
        $this->assertInstanceOf(StrokeClass::class, $strokeClass);
        $this->assertSame($expected, $strokeClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['stroke-[#f00]', ".stroke-\\[\\#f00\\] {stroke: #f00;}"],
            ['stroke-[#ff0000]', ".stroke-\\[\\#ff0000\\] {stroke: #ff0000;}"],
            ['stroke-[rgb(255,0,0)]', ".stroke-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {stroke: rgb(255,0,0);}"],
            ['stroke-[rgba(255,0,0,0.5)]', ".stroke-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {stroke: rgba(255,0,0,0.5);}"],
            ['stroke-[hsl(0,100%,50%)]', ".stroke-\\[hsl\\(0\\2c 100\\%\\2c 50\\%\\)\\] {stroke: hsl(0,100%,50%);}"],
            ['stroke-[hsla(0,100%,50%,0.5)]', ".stroke-\\[hsla\\(0\\2c 100\\%\\2c 50\\%\\2c 0\\.5\\)\\] {stroke: hsla(0,100%,50%,0.5);}"],
        ];
    }
}