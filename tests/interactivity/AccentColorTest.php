<?php

namespace Raakkan\PhpTailwind\Tests\Interactivity;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Interactivity\AccentColorClass;
use PHPUnit\Framework\Attributes\DataProvider;

class AccentColorTest extends TestCase
{
    #[DataProvider('standardAccentColorProvider')]
    public function testStandardAccentColors(string $input, string $expected): void
    {
        $accentColorClass = AccentColorClass::parse($input);
        $this->assertInstanceOf(AccentColorClass::class, $accentColorClass);
        $this->assertSame($expected, $accentColorClass->toCss());
    }

    public static function standardAccentColorProvider(): array
    {
        return [
            ['accent-red-500', ".accent-red-500 {accent-color: #ef4444;}"],
            ['accent-blue-300', ".accent-blue-300 {accent-color: #93c5fd;}"],
            ['accent-green-700', ".accent-green-700 {accent-color: #15803d;}"],
            ['accent-indigo-500', ".accent-indigo-500 {accent-color: #6366f1;}"],
            ['accent-black', ".accent-black {accent-color: #000000;}"],
            ['accent-white', ".accent-white {accent-color: #ffffff;}"],
            ['accent-slate-700', ".accent-slate-700 {accent-color: #334155;}"],
        ];
    }

    #[DataProvider('opacityProvider')]
    public function testOpacity(string $input, string $expected): void
    {
        $accentColorClass = AccentColorClass::parse($input);
        $this->assertInstanceOf(AccentColorClass::class, $accentColorClass);
        $this->assertSame($expected, $accentColorClass->toCss());
    }

    public static function opacityProvider(): array
    {
        return [
            ['accent-red-500/50', ".accent-red-500\/50 {accent-color: rgb(239 68 68 / 0.5);}"],
            ['accent-blue-300/75', ".accent-blue-300\/75 {accent-color: rgb(147 197 253 / 0.75);}"],
            ['accent-green-700/25', ".accent-green-700\/25 {accent-color: rgb(21 128 61 / 0.25);}"],
            ['accent-indigo-500/100', ".accent-indigo-500\/100 {accent-color: rgb(99 102 241 / 1);}"],
            ['accent-purple-100/50', ".accent-purple-100\/50 {accent-color: rgb(243 232 255 / 0.5);}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function testArbitraryValues(string $input, string $expected): void
    {
        $accentColorClass = AccentColorClass::parse($input);
        $this->assertInstanceOf(AccentColorClass::class, $accentColorClass);
        $this->assertSame($expected, $accentColorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['accent-[#1da1f2]', ".accent-\\[\\#1da1f2\\] {accent-color: #1da1f2;}"],
            ['accent-[#50d71e]', ".accent-\\[\\#50d71e\\] {accent-color: #50d71e;}"],
            ['accent-[rgb(255,0,0)]', ".accent-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {accent-color: rgb(255,0,0);}"],
            ['accent-[hsl(200,100%,50%)]', ".accent-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\] {accent-color: hsl(200,100%,50%);}"],
            ['accent-[rgba(255,0,0,0.5)]', ".accent-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {accent-color: rgba(255,0,0,0.5);}"],
        ];
    }

    #[DataProvider('specialColorProvider')]
    public function testSpecialColors(string $input, string $expected): void
    {
        $accentColorClass = AccentColorClass::parse($input);
        $this->assertInstanceOf(AccentColorClass::class, $accentColorClass);
        $this->assertSame($expected, $accentColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['accent-inherit', ".accent-inherit {accent-color: inherit;}"],
            ['accent-current', ".accent-current {accent-color: currentColor;}"],
            ['accent-transparent', ".accent-transparent {accent-color: transparent;}"],
            ['accent-auto', ".accent-auto {accent-color: auto;}"],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $accentColorClass = AccentColorClass::parse($input);
        $this->assertNull($accentColorClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['accent-invalid-color'],
            ['accent-blue-1000'],
            ['accent-red-500/invalid'],
            ['bg-red-500'], // Should not parse background classes
            ['text-blue-300'], // Should not parse text color classes
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function testEdgeCases(string $input, string $expected): void
    {
        $accentColorClass = AccentColorClass::parse($input);
        $this->assertInstanceOf(AccentColorClass::class, $accentColorClass);
        $this->assertSame($expected, $accentColorClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['accent-[#f00]', ".accent-\\[\\#f00\\] {accent-color: #f00;}"],
            ['accent-[#ff0000]', ".accent-\\[\\#ff0000\\] {accent-color: #ff0000;}"],
            ['accent-[rgb(255,0,0)]', ".accent-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {accent-color: rgb(255,0,0);}"],
            ['accent-[rgba(255,0,0,0.5)]', ".accent-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {accent-color: rgba(255,0,0,0.5);}"],
            ['accent-[hsl(0,100%,50%)]', ".accent-\\[hsl\\(0\\2c 100\\%\\2c 50\\%\\)\\] {accent-color: hsl(0,100%,50%);}"],
            ['accent-[hsla(0,100%,50%,0.5)]', ".accent-\\[hsla\\(0\\2c 100\\%\\2c 50\\%\\2c 0\\.5\\)\\] {accent-color: hsla(0,100%,50%,0.5);}"],
            ['accent-slate-50', ".accent-slate-50 {accent-color: #f8fafc;}"],
            ['accent-rose-950', ".accent-rose-950 {accent-color: #4c0519;}"],
        ];
    }
}