<?php

namespace Raakkan\PhpTailwind\Tests\Tailwind\Borders;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Borders\RingWidthClass;

class RingWidthTest extends TestCase
{
    #[DataProvider('validRingWidthClassProvider')]
    public function test_valid_ring_width_class(string $input, string $expected): void
    {
        $ringWidthClass = RingWidthClass::parse($input);
        $this->assertInstanceOf(RingWidthClass::class, $ringWidthClass);
        $this->assertSame($expected, $ringWidthClass->toCss());
    }

    public static function validRingWidthClassProvider(): array
    {
        return [
            ['ring', '.ring {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}'],
            ['ring-0', '.ring-0 {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}'],
            ['ring-1', '.ring-1 {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}'],
            ['ring-2', '.ring-2 {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}'],
            ['ring-4', '.ring-4 {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}'],
            ['ring-8', '.ring-8 {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(8px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}'],
            ['ring-inset', '.ring-inset {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);--tw-ring-inset: inset;}'],
            ['ring-[10px]', '.ring-\\[10px\\] {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(10px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}'],
            ['ring-[0.5em]', '.ring-\\[0\\.5em\\] {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0.5em + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}'],
            ['ring-[3rem]', '.ring-\\[3rem\\] {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3rem + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}'],
            // ['ring-[length:var(--ring-width)]', ".ring-\\[length\\:var\\(--ring-width\\)\\] {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(length:var(--ring-width) + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}"],
        ];
    }

    #[DataProvider('invalidRingWidthClassProvider')]
    public function test_invalid_ring_width_class(string $input): void
    {
        $ringWidthClass = RingWidthClass::parse($input);
        $this->assertInstanceOf(RingWidthClass::class, $ringWidthClass);
        $this->assertSame('', $ringWidthClass->toCss());
    }

    public static function invalidRingWidthClassProvider(): array
    {
        return [
            ['ring-3'],
            ['ring-5'],
            ['ring-6'],
            ['ring-7'],
            ['ring-9'],
            ['ring-10'],
            // ['ring-[invalid]'],
            // ['ring-[10]'],
            // ['ring-[em]'],
            ['ring-[]'],
            ['ring-[10px'],
            ['ring-10px]'],
        ];
    }

    public function test_non_ring_width_class(): void
    {
        $this->assertNull(RingWidthClass::parse('text-lg'));
        $this->assertNull(RingWidthClass::parse('bg-red-500'));
        $this->assertNull(RingWidthClass::parse('p-4'));
    }

    // public function testCaseInsensitivity(): void
    // {
    //     $lowerCase = RingWidthClass::parse('ring-2');
    //     $upperCase = RingWidthClass::parse('RING-2');
    //     $mixedCase = RingWidthClass::parse('RiNg-2');

    //     $this->assertNotNull($lowerCase);
    //     // $this->assertNotNull($upperCase);
    //     $this->assertNotNull($mixedCase);

    //     $this->assertSame($lowerCase->toCss(), $upperCase->toCss());
    //     $this->assertSame($lowerCase->toCss(), $mixedCase->toCss());
    // }

    // public function testArbitraryValueWithSpaces(): void
    // {
    //     $ringWidthClass = RingWidthClass::parse('ring-[calc(1rem+2px)]');
    //     $this->assertInstanceOf(RingWidthClass::class, $ringWidthClass);
    //     $expected = ".ring-\\[calc\\(1rem\\+2px\\)\\] {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(calc(1rem+2px) + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);}";
    //     $this->assertSame($expected, $ringWidthClass->toCss());
    // }

    // public function testInsetWithArbitraryValue(): void
    // {
    //     $ringWidthClass = RingWidthClass::parse('ring-inset ring-[5px]');
    //     $this->assertInstanceOf(RingWidthClass::class, $ringWidthClass);
    //     $expected = ".ring-inset.ring-\\[5px\\] {--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(5px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);--tw-ring-inset: inset;}";
    //     $this->assertSame($expected, $ringWidthClass->toCss());
    // }
}
