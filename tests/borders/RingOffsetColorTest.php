<?php

namespace Raakkan\PhpTailwind\Tests\Borders;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\RingOffsetColorClass;
use PHPUnit\Framework\Attributes\DataProvider;

class RingOffsetColorTest extends TestCase
{
    #[DataProvider('standardRingOffsetColorProvider')]
    public function testStandardRingOffsetColors(string $input, string $expected): void
    {
        $ringOffsetColorClass = RingOffsetColorClass::parse($input);
        $this->assertInstanceOf(RingOffsetColorClass::class, $ringOffsetColorClass);
        $this->assertSame($expected, $ringOffsetColorClass->toCss());
    }

    public static function standardRingOffsetColorProvider(): array
    {
        return [
            ['ring-offset-red-500', ".ring-offset-red-500 {--tw-ring-offset-color: #ef4444;}"],
            ['ring-offset-blue-300', ".ring-offset-blue-300 {--tw-ring-offset-color: #93c5fd;}"],
            ['ring-offset-green-700', ".ring-offset-green-700 {--tw-ring-offset-color: #15803d;}"],
            ['ring-offset-indigo-500', ".ring-offset-indigo-500 {--tw-ring-offset-color: #6366f1;}"],
            ['ring-offset-black', ".ring-offset-black {--tw-ring-offset-color: #000000;}"],
            ['ring-offset-white', ".ring-offset-white {--tw-ring-offset-color: #ffffff;}"],
            ['ring-offset-slate-700', ".ring-offset-slate-700 {--tw-ring-offset-color: #334155;}"],
        ];
    }

    #[DataProvider('opacityProvider')]
    public function testOpacity(string $input, string $expected): void
    {
        $ringOffsetColorClass = RingOffsetColorClass::parse($input);
        $this->assertInstanceOf(RingOffsetColorClass::class, $ringOffsetColorClass);
        $this->assertSame($expected, $ringOffsetColorClass->toCss());
    }

    public static function opacityProvider(): array
    {
        return [
            ['ring-offset-red-500/50', ".ring-offset-red-500\/50 {--tw-ring-offset-color: rgb(239 68 68 / 0.5);}"],
            ['ring-offset-blue-300/75', ".ring-offset-blue-300\/75 {--tw-ring-offset-color: rgb(147 197 253 / 0.75);}"],
            ['ring-offset-green-700/25', ".ring-offset-green-700\/25 {--tw-ring-offset-color: rgb(21 128 61 / 0.25);}"],
            ['ring-offset-indigo-500/100', ".ring-offset-indigo-500\/100 {--tw-ring-offset-color: rgb(99 102 241 / 1);}"],
            ['ring-offset-purple-100/50', ".ring-offset-purple-100\/50 {--tw-ring-offset-color: rgb(243 232 255 / 0.5);}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function testArbitraryValues(string $input, string $expected): void
    {
        $ringOffsetColorClass = RingOffsetColorClass::parse($input);
        $this->assertInstanceOf(RingOffsetColorClass::class, $ringOffsetColorClass);
        $this->assertSame($expected, $ringOffsetColorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['ring-offset-[#1da1f2]', ".ring-offset-\\[\\#1da1f2\\] {--tw-ring-offset-color: #1da1f2;}"],
            ['ring-offset-[#50d71e]', ".ring-offset-\\[\\#50d71e\\] {--tw-ring-offset-color: #50d71e;}"],
            ['ring-offset-[rgb(255,0,0)]', ".ring-offset-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {--tw-ring-offset-color: rgb(255,0,0);}"],
            ['ring-offset-[hsl(200,100%,50%)]', ".ring-offset-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\] {--tw-ring-offset-color: hsl(200,100%,50%);}"],
            ['ring-offset-[rgba(255,0,0,0.5)]', ".ring-offset-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {--tw-ring-offset-color: rgba(255,0,0,0.5);}"],
        ];
    }

    #[DataProvider('specialColorProvider')]
    public function testSpecialColors(string $input, string $expected): void
    {
        $ringOffsetColorClass = RingOffsetColorClass::parse($input);
        $this->assertInstanceOf(RingOffsetColorClass::class, $ringOffsetColorClass);
        $this->assertSame($expected, $ringOffsetColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['ring-offset-inherit', ".ring-offset-inherit {--tw-ring-offset-color: inherit;}"],
            ['ring-offset-current', ".ring-offset-current {--tw-ring-offset-color: currentColor;}"],
            ['ring-offset-transparent', ".ring-offset-transparent {--tw-ring-offset-color: transparent;}"],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $ringOffsetColorClass = RingOffsetColorClass::parse($input);
        $this->assertNull($ringOffsetColorClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['ring-offset-invalid-color'],
            ['ring-offset-blue-1000'],
            ['ring-offset-red-500/invalid'],
            ['ring-red-500'], // Should not parse ring classes without offset
            ['outline-red-500'], // Should not parse outline classes
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function testEdgeCases(string $input, string $expected): void
    {
        $ringOffsetColorClass = RingOffsetColorClass::parse($input);
        $this->assertInstanceOf(RingOffsetColorClass::class, $ringOffsetColorClass);
        $this->assertSame($expected, $ringOffsetColorClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['ring-offset-[#f00]', ".ring-offset-\\[\\#f00\\] {--tw-ring-offset-color: #f00;}"],
            ['ring-offset-[#ff0000]', ".ring-offset-\\[\\#ff0000\\] {--tw-ring-offset-color: #ff0000;}"],
            ['ring-offset-[rgb(255,0,0)]', ".ring-offset-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {--tw-ring-offset-color: rgb(255,0,0);}"],
            ['ring-offset-[rgba(255,0,0,0.5)]', ".ring-offset-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {--tw-ring-offset-color: rgba(255,0,0,0.5);}"],
            ['ring-offset-[hsl(0,100%,50%)]', ".ring-offset-\\[hsl\\(0\\2c 100\\%\\2c 50\\%\\)\\] {--tw-ring-offset-color: hsl(0,100%,50%);}"],
            ['ring-offset-[hsla(0,100%,50%,0.5)]', ".ring-offset-\\[hsla\\(0\\2c 100\\%\\2c 50\\%\\2c 0\\.5\\)\\] {--tw-ring-offset-color: hsla(0,100%,50%,0.5);}"],
            ['ring-offset-slate-50', ".ring-offset-slate-50 {--tw-ring-offset-color: #f8fafc;}"],
            ['ring-offset-rose-950', ".ring-offset-rose-950 {--tw-ring-offset-color: #4c0519;}"],
        ];
    }
}