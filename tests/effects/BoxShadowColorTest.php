<?php

namespace Raakkan\PhpTailwind\Tests\Effects;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Effects\BoxShadowColorClass;

class BoxShadowColorTest extends TestCase
{
    #[DataProvider('standardColorProvider')]
    public function testStandardColors(string $input, string $expected): void
    {
        $boxShadowColorClass = BoxShadowColorClass::parse($input);
        $this->assertInstanceOf(BoxShadowColorClass::class, $boxShadowColorClass);
        $this->assertSame($expected, $boxShadowColorClass->toCss());
    }

    public static function standardColorProvider(): array
    {
        return [
            ['shadow-red-500', '.shadow-red-500 {--tw-shadow-color: #ef4444; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-blue-300', '.shadow-blue-300 {--tw-shadow-color: #93c5fd; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-green-700', '.shadow-green-700 {--tw-shadow-color: #15803d; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-indigo-500', '.shadow-indigo-500 {--tw-shadow-color: #6366f1; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-black', '.shadow-black {--tw-shadow-color: #000000; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-white', '.shadow-white {--tw-shadow-color: #ffffff; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-slate-700', '.shadow-slate-700 {--tw-shadow-color: #334155; --tw-shadow: var(--tw-shadow-colored);}'],
        ];
    }

    #[DataProvider('opacityProvider')]
    public function testOpacity(string $input, string $expected): void
    {
        $boxShadowColorClass = BoxShadowColorClass::parse($input);
        $this->assertInstanceOf(BoxShadowColorClass::class, $boxShadowColorClass);
        $this->assertSame($expected, $boxShadowColorClass->toCss());
    }

    public static function opacityProvider(): array
    {
        return [
            ['shadow-red-500/50', ".shadow-red-500\/50 {--tw-shadow-color: rgb(239 68 68 / 0.5); --tw-shadow: var(--tw-shadow-colored);}"],
            ['shadow-blue-300/75', ".shadow-blue-300\/75 {--tw-shadow-color: rgb(147 197 253 / 0.75); --tw-shadow: var(--tw-shadow-colored);}"],
            ['shadow-green-700/25', ".shadow-green-700\/25 {--tw-shadow-color: rgb(21 128 61 / 0.25); --tw-shadow: var(--tw-shadow-colored);}"],
            ['shadow-indigo-500/100', ".shadow-indigo-500\/100 {--tw-shadow-color: rgb(99 102 241 / 1); --tw-shadow: var(--tw-shadow-colored);}"],
            ['shadow-purple-100/50', ".shadow-purple-100\/50 {--tw-shadow-color: rgb(243 232 255 / 0.5); --tw-shadow: var(--tw-shadow-colored);}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function testArbitraryValues(string $input, string $expected): void
    {
        $boxShadowColorClass = BoxShadowColorClass::parse($input);
        $this->assertInstanceOf(BoxShadowColorClass::class, $boxShadowColorClass);
        $this->assertSame($expected, $boxShadowColorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['shadow-[#1da1f2]', '.shadow-\\[\\#1da1f2\\] {--tw-shadow-color: #1da1f2; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-[#50d71e]', '.shadow-\\[\\#50d71e\\] {--tw-shadow-color: #50d71e; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-[rgb(255,0,0)]', '.shadow-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {--tw-shadow-color: rgb(255,0,0); --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-[hsl(200,100%,50%)]', '.shadow-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\] {--tw-shadow-color: hsl(200,100%,50%); --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-[rgba(255,0,0,0.5)]', '.shadow-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {--tw-shadow-color: rgba(255,0,0,0.5); --tw-shadow: var(--tw-shadow-colored);}'],
        ];
    }

    #[DataProvider('specialColorProvider')]
    public function testSpecialColors(string $input, string $expected): void
    {
        $boxShadowColorClass = BoxShadowColorClass::parse($input);
        $this->assertInstanceOf(BoxShadowColorClass::class, $boxShadowColorClass);
        $this->assertSame($expected, $boxShadowColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['shadow-inherit', '.shadow-inherit {--tw-shadow-color: inherit; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-current', '.shadow-current {--tw-shadow-color: currentColor; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-transparent', '.shadow-transparent {--tw-shadow-color: transparent; --tw-shadow: var(--tw-shadow-colored);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $boxShadowColorClass = BoxShadowColorClass::parse($input);
        $this->assertNull($boxShadowColorClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['shadow-invalid-color'],
            ['shadow-blue-1000'],
            ['shadow-red-500/invalid'],
            ['ring-red-500'], // Should not parse ring classes
            ['outline-red-500'], // Should not parse outline classes
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function testEdgeCases(string $input, string $expected): void
    {
        $boxShadowColorClass = BoxShadowColorClass::parse($input);
        $this->assertInstanceOf(BoxShadowColorClass::class, $boxShadowColorClass);
        $this->assertSame($expected, $boxShadowColorClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['shadow-[#f00]', '.shadow-\\[\\#f00\\] {--tw-shadow-color: #f00; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-[#ff0000]', '.shadow-\\[\\#ff0000\\] {--tw-shadow-color: #ff0000; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-[rgb(255,0,0)]', '.shadow-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {--tw-shadow-color: rgb(255,0,0); --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-[rgba(255,0,0,0.5)]', '.shadow-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {--tw-shadow-color: rgba(255,0,0,0.5); --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-[hsl(0,100%,50%)]', '.shadow-\\[hsl\\(0\\2c 100\\%\\2c 50\\%\\)\\] {--tw-shadow-color: hsl(0,100%,50%); --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-[hsla(0,100%,50%,0.5)]', '.shadow-\\[hsla\\(0\\2c 100\\%\\2c 50\\%\\2c 0\\.5\\)\\] {--tw-shadow-color: hsla(0,100%,50%,0.5); --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-slate-50', '.shadow-slate-50 {--tw-shadow-color: #f8fafc; --tw-shadow: var(--tw-shadow-colored);}'],
            ['shadow-rose-950', '.shadow-rose-950 {--tw-shadow-color: #4c0519; --tw-shadow: var(--tw-shadow-colored);}'],
        ];
    }
}
