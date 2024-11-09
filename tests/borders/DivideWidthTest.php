<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\DivideWidthClass;

class DivideWidthTest extends TestCase
{
    #[DataProvider('divideWidthClassProvider')]
    public function testDivideWidthClass(string $input, string $expected): void
    {
        $divideWidthClass = DivideWidthClass::parse($input);
        $this->assertInstanceOf(DivideWidthClass::class, $divideWidthClass);
        $this->assertSame($expected, $divideWidthClass->toCss());
    }

    public static function divideWidthClassProvider(): array
    {
        return [
            // Default
            ['divide-x', '.divide-x > :not([hidden]) ~ :not([hidden]) {--tw-divide-x-reverse: 0;border-right-width: calc(1px * var(--tw-divide-x-reverse));border-left-width: calc(1px * calc(1 - var(--tw-divide-x-reverse)));}'],
            ['divide-y', '.divide-y > :not([hidden]) ~ :not([hidden]) {--tw-divide-y-reverse: 0;border-bottom-width: calc(1px * var(--tw-divide-y-reverse));border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));}'],

            // Sizes
            ['divide-x-0', '.divide-x-0 > :not([hidden]) ~ :not([hidden]) {--tw-divide-x-reverse: 0;border-right-width: calc(0px * var(--tw-divide-x-reverse));border-left-width: calc(0px * calc(1 - var(--tw-divide-x-reverse)));}'],
            ['divide-y-2', '.divide-y-2 > :not([hidden]) ~ :not([hidden]) {--tw-divide-y-reverse: 0;border-bottom-width: calc(2px * var(--tw-divide-y-reverse));border-top-width: calc(2px * calc(1 - var(--tw-divide-y-reverse)));}'],
            ['divide-x-4', '.divide-x-4 > :not([hidden]) ~ :not([hidden]) {--tw-divide-x-reverse: 0;border-right-width: calc(4px * var(--tw-divide-x-reverse));border-left-width: calc(4px * calc(1 - var(--tw-divide-x-reverse)));}'],
            ['divide-y-8', '.divide-y-8 > :not([hidden]) ~ :not([hidden]) {--tw-divide-y-reverse: 0;border-bottom-width: calc(8px * var(--tw-divide-y-reverse));border-top-width: calc(8px * calc(1 - var(--tw-divide-y-reverse)));}'],

            // Reverse
            ['divide-x-reverse', '.divide-x-reverse > :not([hidden]) ~ :not([hidden]) {--tw-divide-x-reverse: 1;}'],
            ['divide-y-reverse', '.divide-y-reverse > :not([hidden]) ~ :not([hidden]) {--tw-divide-y-reverse: 1;}'],
            // ['divide-x-2-reverse', ".divide-x-2-reverse > :not([hidden]) ~ :not([hidden]) {--tw-divide-x-reverse: 1;border-right-width: calc(2px * var(--tw-divide-x-reverse));border-left-width: calc(2px * calc(1 - var(--tw-divide-x-reverse)));}"],
            // ['divide-y-4-reverse', ".divide-y-4-reverse > :not([hidden]) ~ :not([hidden]) {--tw-divide-y-reverse: 1;border-bottom-width: calc(4px * var(--tw-divide-y-reverse));border-top-width: calc(4px * calc(1 - var(--tw-divide-y-reverse)));}"],
        ];
    }

    #[DataProvider('arbitraryDivideWidthClassProvider')]
    public function testArbitraryDivideWidthClass(string $input, string $expected): void
    {
        $divideWidthClass = DivideWidthClass::parse($input);
        $this->assertInstanceOf(DivideWidthClass::class, $divideWidthClass);
        $this->assertSame($expected, $divideWidthClass->toCss());
    }

    public static function arbitraryDivideWidthClassProvider(): array
    {
        return [
            ['divide-x-[3px]', '.divide-x-\\[3px\\] > :not([hidden]) ~ :not([hidden]) {--tw-divide-x-reverse: 0;border-right-width: calc(3px * var(--tw-divide-x-reverse));border-left-width: calc(3px * calc(1 - var(--tw-divide-x-reverse)));}'],
            ['divide-y-[0.5em]', '.divide-y-\\[0\\.5em\\] > :not([hidden]) ~ :not([hidden]) {--tw-divide-y-reverse: 0;border-bottom-width: calc(0.5em * var(--tw-divide-y-reverse));border-top-width: calc(0.5em * calc(1 - var(--tw-divide-y-reverse)));}'],
            ['divide-x-[10%]', '.divide-x-\\[10\\%\\] > :not([hidden]) ~ :not([hidden]) {--tw-divide-x-reverse: 0;border-right-width: calc(10% * var(--tw-divide-x-reverse));border-left-width: calc(10% * calc(1 - var(--tw-divide-x-reverse)));}'],
            // ['divide-y-[calc(1rem+2px)]', ".divide-y-\\[calc\\(1rem\\+2px\\)\\] > :not([hidden]) ~ :not([hidden]) {--tw-divide-y-reverse: 0;border-bottom-width: calc(calc(1rem+2px) * var(--tw-divide-y-reverse));border-top-width: calc(calc(1rem+2px) * calc(1 - var(--tw-divide-y-reverse)));}"],
            ['divide-x-[var(--divide-width)]', '.divide-x-\\[var\\(--divide-width\\)\\] > :not([hidden]) ~ :not([hidden]) {--tw-divide-x-reverse: 0;border-right-width: calc(var(--divide-width) * var(--tw-divide-x-reverse));border-left-width: calc(var(--divide-width) * calc(1 - var(--tw-divide-x-reverse)));}'],
        ];
    }

    public function testInvalidDivideWidthClass(): void
    {
        $this->assertNull(DivideWidthClass::parse('invalid-class'));
    }

    #[DataProvider('invalidDivideWidthValueProvider')]
    public function testDivideWidthClassWithInvalidValue(string $input): void
    {
        $divideWidthClass = DivideWidthClass::parse($input);
        $this->assertInstanceOf(DivideWidthClass::class, $divideWidthClass);
        $this->assertSame('', $divideWidthClass->toCss());
    }

    public static function invalidDivideWidthValueProvider(): array
    {
        return [
            ['divide-x-1'],
            ['divide-y-3'],
            ['divide-x-5'],
            ['divide-y-7'],
            ['divide-x-9'],
            ['divide-y-10'],
        ];
    }

    #[DataProvider('invalidArbitraryDivideWidthClassProvider')]
    public function testInvalidArbitraryDivideWidthClass(string $input): void
    {
        $divideWidthClass = DivideWidthClass::parse($input);
        $this->assertInstanceOf(DivideWidthClass::class, $divideWidthClass);
        $this->assertSame('', $divideWidthClass->toCss());
    }

    public static function invalidArbitraryDivideWidthClassProvider(): array
    {
        return [
            // ['divide-x-[invalid]'],
            // ['divide-y-[10]'],
            // ['divide-x-[em]'],
            ['divide-y-[]'],
            ['divide-x-[10px'],
            ['divide-y-10px]'],
        ];
    }
}
