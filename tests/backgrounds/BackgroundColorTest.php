<?php

namespace Raakkan\PhpTailwind\Tests\Backgrounds;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Backgrounds\BackgroundColorClass;

//TODO : bg-[#FF9933] dark:bg-[#E67300] this classes not applayed in html elament test ok
class BackgroundColorTest extends TestCase
{
    #[DataProvider('standardColorProvider')]
    public function test_standard_colors(string $input, string $expected): void
    {
        $bgColorClass = BackgroundColorClass::parse($input);
        $this->assertInstanceOf(BackgroundColorClass::class, $bgColorClass);
        $this->assertSame($expected, $bgColorClass->toCss());
    }

    public static function standardColorProvider(): array
    {
        return [
            ['bg-red-500', '.bg-red-500 {--tw-bg-opacity: 1;background-color: rgb(239 68 68 / var(--tw-bg-opacity));}'],
            ['bg-blue-300', '.bg-blue-300 {--tw-bg-opacity: 1;background-color: rgb(147 197 253 / var(--tw-bg-opacity));}'],
            ['bg-green-700', '.bg-green-700 {--tw-bg-opacity: 1;background-color: rgb(21 128 61 / var(--tw-bg-opacity));}'],
            ['bg-indigo-500', '.bg-indigo-500 {--tw-bg-opacity: 1;background-color: rgb(99 102 241 / var(--tw-bg-opacity));}'],
            ['bg-black', '.bg-black {--tw-bg-opacity: 1;background-color: rgb(0 0 0 / var(--tw-bg-opacity));}'],
            ['bg-white', '.bg-white {--tw-bg-opacity: 1;background-color: rgb(255 255 255 / var(--tw-bg-opacity));}'],
            ['bg-slate-700', '.bg-slate-700 {--tw-bg-opacity: 1;background-color: rgb(51 65 85 / var(--tw-bg-opacity));}'],
            ['bg-orange-50', '.bg-orange-50 {--tw-bg-opacity: 1;background-color: rgb(255 247 237 / var(--tw-bg-opacity));}'],
        ];
    }

    #[DataProvider('opacityProvider')]
    public function test_opacity(string $input, string $expected): void
    {
        $bgColorClass = BackgroundColorClass::parse($input);
        $this->assertInstanceOf(BackgroundColorClass::class, $bgColorClass);
        $this->assertSame($expected, $bgColorClass->toCss());
    }

    public static function opacityProvider(): array
    {
        return [
            ['bg-red-500/50', ".bg-red-500\/50 {background-color: rgb(239 68 68 / 0.5);}"],
            ['bg-blue-300/75', ".bg-blue-300\/75 {background-color: rgb(147 197 253 / 0.75);}"],
            ['bg-green-700/25', ".bg-green-700\/25 {background-color: rgb(21 128 61 / 0.25);}"],
            ['bg-indigo-500/100', ".bg-indigo-500\/100 {background-color: rgb(99 102 241 / 1);}"],
            ['bg-purple-100/50', ".bg-purple-100\/50 {background-color: rgb(243 232 255 / 0.5);}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function test_arbitrary_values(string $input, string $expected): void
    {
        $bgColorClass = BackgroundColorClass::parse($input);
        $this->assertInstanceOf(BackgroundColorClass::class, $bgColorClass);
        $this->assertSame($expected, $bgColorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['bg-[#FF9933]', '.bg-\\[\\#FF9933\\] {--tw-bg-opacity: 1;background-color: #FF9933;}'],
            ['bg-[#1da1f2]', '.bg-\\[\\#1da1f2\\] {--tw-bg-opacity: 1;background-color: #1da1f2;}'],
            ['bg-[#50d71e]', '.bg-\\[\\#50d71e\\] {--tw-bg-opacity: 1;background-color: #50d71e;}'],
            ['bg-[rgb(255,0,0)]', '.bg-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {--tw-bg-opacity: 1;background-color: rgb(255,0,0);}'],
            ['bg-[hsl(200,100%,50%)]', '.bg-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\] {--tw-bg-opacity: 1;background-color: hsl(200,100%,50%);}'],
            ['bg-[rgba(255,0,0,0.5)]', '.bg-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {--tw-bg-opacity: 1;background-color: rgba(255,0,0,0.5);}'],
        ];
    }

    #[DataProvider('specialColorProvider')]
    public function test_special_colors(string $input, string $expected): void
    {
        $bgColorClass = BackgroundColorClass::parse($input);
        $this->assertInstanceOf(BackgroundColorClass::class, $bgColorClass);
        $this->assertSame($expected, $bgColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['bg-inherit', '.bg-inherit {--tw-bg-opacity: 1;background-color: inherit;}'],
            ['bg-current', '.bg-current {--tw-bg-opacity: 1;background-color: currentColor;}'],
            ['bg-transparent', '.bg-transparent {--tw-bg-opacity: 1;background-color: transparent;}'],
        ];
    }

    #[DataProvider('invalidColorProvider')]
    public function test_invalid_colors(string $input): void
    {
        $bgColorClass = BackgroundColorClass::parse($input);
        $this->assertNull($bgColorClass);
    }

    public static function invalidColorProvider(): array
    {
        return [
            ['bg-invalid'],
            ['bg-blue-1000'],
            ['bg-red-500/invalid'],
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function test_edge_cases(string $input, string $expected): void
    {
        $bgColorClass = BackgroundColorClass::parse($input);
        $this->assertInstanceOf(BackgroundColorClass::class, $bgColorClass);
        $this->assertSame($expected, $bgColorClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['bg-[#f00]', '.bg-\\[\\#f00\\] {--tw-bg-opacity: 1;background-color: #f00;}'],
            ['bg-[#ff0000]', '.bg-\\[\\#ff0000\\] {--tw-bg-opacity: 1;background-color: #ff0000;}'],
            ['bg-[rgb(255,0,0)]', '.bg-\\[rgb\\(255\\2c 0\\2c 0\\)\\] {--tw-bg-opacity: 1;background-color: rgb(255,0,0);}'],
            ['bg-[rgba(255,0,0,0.5)]', '.bg-\\[rgba\\(255\\2c 0\\2c 0\\2c 0\\.5\\)\\] {--tw-bg-opacity: 1;background-color: rgba(255,0,0,0.5);}'],
            ['bg-[hsl(0,100%,50%)]', '.bg-\\[hsl\\(0\\2c 100\\%\\2c 50\\%\\)\\] {--tw-bg-opacity: 1;background-color: hsl(0,100%,50%);}'],
            ['bg-[hsla(0,100%,50%,0.5)]', '.bg-\\[hsla\\(0\\2c 100\\%\\2c 50\\%\\2c 0\\.5\\)\\] {--tw-bg-opacity: 1;background-color: hsla(0,100%,50%,0.5);}'],
            ['bg-slate-50', '.bg-slate-50 {--tw-bg-opacity: 1;background-color: rgb(248 250 252 / var(--tw-bg-opacity));}'],
            ['bg-rose-950', '.bg-rose-950 {--tw-bg-opacity: 1;background-color: rgb(76 5 25 / var(--tw-bg-opacity));}'],
        ];
    }
}
