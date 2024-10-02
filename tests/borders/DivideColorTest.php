<?php

namespace Raakkan\PhpTailwind\Tests\Borders;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\DivideColorClass;
use PHPUnit\Framework\Attributes\DataProvider;

class DivideColorTest extends TestCase
{
    #[DataProvider('standardDivideColorProvider')]
    public function testStandardDivideColors(string $input, string $expected): void
    {
        $divideColorClass = DivideColorClass::parse($input);
        $this->assertInstanceOf(DivideColorClass::class, $divideColorClass);
        $this->assertSame($expected, $divideColorClass->toCss());
    }

    public static function standardDivideColorProvider(): array
    {
        return [
            ['divide-red-500', ".divide-red-500 > :not([hidden]) ~ :not([hidden]){--tw-divide-opacity:1;border-color:rgb(239 68 68 / var(--tw-divide-opacity));}"],
            ['divide-blue-300', ".divide-blue-300 > :not([hidden]) ~ :not([hidden]){--tw-divide-opacity:1;border-color:rgb(147 197 253 / var(--tw-divide-opacity));}"],
            ['divide-green-700', ".divide-green-700 > :not([hidden]) ~ :not([hidden]){--tw-divide-opacity:1;border-color:rgb(21 128 61 / var(--tw-divide-opacity));}"],
            ['divide-indigo-500', ".divide-indigo-500 > :not([hidden]) ~ :not([hidden]){--tw-divide-opacity:1;border-color:rgb(99 102 241 / var(--tw-divide-opacity));}"],
            ['divide-transparent', ".divide-transparent > :not([hidden]) ~ :not([hidden]){border-color:transparent;}"],
            ['divide-current', ".divide-current > :not([hidden]) ~ :not([hidden]){border-color:currentColor;}"],
            ['divide-black', ".divide-black > :not([hidden]) ~ :not([hidden]){--tw-divide-opacity:1;border-color:rgb(0 0 0 / var(--tw-divide-opacity));}"],
            ['divide-white', ".divide-white > :not([hidden]) ~ :not([hidden]){--tw-divide-opacity:1;border-color:rgb(255 255 255 / var(--tw-divide-opacity));}"],
        ];
    }

    #[DataProvider('opacityProvider')]
    public function testOpacity(string $input, string $expected): void
    {
        $divideColorClass = DivideColorClass::parse($input);
        $this->assertInstanceOf(DivideColorClass::class, $divideColorClass);
        $this->assertSame($expected, $divideColorClass->toCss());
    }

    public static function opacityProvider(): array
    {
        return [
            ['divide-red-500/50', ".divide-red-500\/50 > :not([hidden]) ~ :not([hidden]){border-color:rgb(239 68 68 / 0.5);}"],
            ['divide-blue-300/75', ".divide-blue-300\/75 > :not([hidden]) ~ :not([hidden]){border-color:rgb(147 197 253 / 0.75);}"],
            ['divide-green-700/25', ".divide-green-700\/25 > :not([hidden]) ~ :not([hidden]){border-color:rgb(21 128 61 / 0.25);}"],
            ['divide-indigo-500/100', ".divide-indigo-500\/100 > :not([hidden]) ~ :not([hidden]){border-color:rgb(99 102 241 / 1);}"],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function testArbitraryValues(string $input, string $expected): void
    {
        $divideColorClass = DivideColorClass::parse($input);
        $this->assertInstanceOf(DivideColorClass::class, $divideColorClass);
        $this->assertSame($expected, $divideColorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['divide-[#1da1f2]', ".divide-\\[\\#1da1f2\\] > :not([hidden]) ~ :not([hidden]){--tw-divide-opacity:1;border-color:rgb(29 161 242 / var(--tw-divide-opacity));}"],
            ['divide-[rgb(255,0,0)]', ".divide-\\[rgb\\(255\\2c 0\\2c 0\\)\\] > :not([hidden]) ~ :not([hidden]){--tw-divide-opacity:1;border-color:rgb(255 0 0 / var(--tw-divide-opacity));}"],
            ['divide-[hsl(200,100%,50%)]', ".divide-\\[hsl\\(200\\2c 100\\%\\2c 50\\%\\)\\] > :not([hidden]) ~ :not([hidden]){--tw-divide-opacity:1;border-color:hsl(200 100% 50% / var(--tw-divide-opacity));}"],
            // ['divide-[#0000ff]/75', ".divide-\\[\\#0000ff\\]\/75 > :not([hidden]) ~ :not([hidden]){border-color:rgb(0 0 255 / 0.75);}"],
        ];
    }

    #[DataProvider('specialColorProvider')]
    public function testSpecialColors(string $input, string $expected): void
    {
        $divideColorClass = DivideColorClass::parse($input);
        $this->assertInstanceOf(DivideColorClass::class, $divideColorClass);
        $this->assertSame($expected, $divideColorClass->toCss());
    }

    public static function specialColorProvider(): array
    {
        return [
            ['divide-inherit', ".divide-inherit > :not([hidden]) ~ :not([hidden]){border-color:inherit;}"],
            ['divide-current', ".divide-current > :not([hidden]) ~ :not([hidden]){border-color:currentColor;}"],
            ['divide-transparent', ".divide-transparent > :not([hidden]) ~ :not([hidden]){border-color:transparent;}"],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $divideColorClass = DivideColorClass::parse($input);
        $this->assertNull($divideColorClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['divide-invalid-color'],
            ['divide-blue-1000'],
            ['divide-red-500/invalid'],
        ];
    }
}