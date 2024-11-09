<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpaceClass;

class SpaceTest extends TestCase
{
    #[DataProvider('spaceClassProvider')]
    public function testSpaceClass(string $input, string $expected): void
    {
        $spaceClass = SpaceClass::parse($input);
        $this->assertInstanceOf(SpaceClass::class, $spaceClass);
        $this->assertSame($expected, $spaceClass->toCss());
    }

    public static function spaceClassProvider(): array
    {
        return [
            ['space-x-0', '.space-x-0>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(0px * var(--tw-space-x-reverse));margin-left:calc(0px * calc(1 - var(--tw-space-x-reverse)));}'],
            ['space-x-1', '.space-x-1>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(0.25rem * var(--tw-space-x-reverse));margin-left:calc(0.25rem * calc(1 - var(--tw-space-x-reverse)));}'],
            ['space-x-2', '.space-x-2>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(0.5rem * var(--tw-space-x-reverse));margin-left:calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));}'],
            ['space-x-4', '.space-x-4>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(1rem * var(--tw-space-x-reverse));margin-left:calc(1rem * calc(1 - var(--tw-space-x-reverse)));}'],
            ['space-x-8', '.space-x-8>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(2rem * var(--tw-space-x-reverse));margin-left:calc(2rem * calc(1 - var(--tw-space-x-reverse)));}'],
            ['space-x-px', '.space-x-px>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(1px * var(--tw-space-x-reverse));margin-left:calc(1px * calc(1 - var(--tw-space-x-reverse)));}'],
            ['space-y-0', '.space-y-0>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(0px * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0px * var(--tw-space-y-reverse));}'],
            ['space-y-1', '.space-y-1>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(0.25rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0.25rem * var(--tw-space-y-reverse));}'],
            ['space-y-2', '.space-y-2>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(0.5rem * var(--tw-space-y-reverse));}'],
            ['space-y-4', '.space-y-4>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1rem * var(--tw-space-y-reverse));}'],
            ['space-y-8', '.space-y-8>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(2rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(2rem * var(--tw-space-y-reverse));}'],
            ['space-y-px', '.space-y-px>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1px * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1px * var(--tw-space-y-reverse));}'],
            ['space-x-reverse', '.space-x-reverse>:not([hidden])~:not([hidden]){--tw-space-x-reverse:1;}'],
            ['space-y-reverse', '.space-y-reverse>:not([hidden])~:not([hidden]){--tw-space-y-reverse:1;}'],
        ];
    }

    public function testInvalidSpaceClass(): void
    {
        $this->assertNull(SpaceClass::parse('invalid-class'));
    }

    public function testSpaceClassWithInvalidValue(): void
    {
        $spaceClass = SpaceClass::parse('space-x-invalid');
        $this->assertInstanceOf(SpaceClass::class, $spaceClass);
        $this->assertSame('', $spaceClass->toCss());

        $spaceClass = SpaceClass::parse('space-y-invalid');
        $this->assertInstanceOf(SpaceClass::class, $spaceClass);
        $this->assertSame('', $spaceClass->toCss());
    }

    #[DataProvider('negativeSpaceClassProvider')]
    public function testNegativeSpaceClass(string $input, string $expected): void
    {
        $spaceClass = SpaceClass::parse($input);
        $this->assertInstanceOf(SpaceClass::class, $spaceClass);
        $this->assertSame($expected, $spaceClass->toCss());
    }

    public static function negativeSpaceClassProvider(): array
    {
        return [
            ['-space-x-1', '.-space-x-1>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(-0.25rem * var(--tw-space-x-reverse));margin-left:calc(-0.25rem * calc(1 - var(--tw-space-x-reverse)));}'],
            ['-space-x-2', '.-space-x-2>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(-0.5rem * var(--tw-space-x-reverse));margin-left:calc(-0.5rem * calc(1 - var(--tw-space-x-reverse)));}'],
            ['-space-y-1', '.-space-y-1>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(-0.25rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(-0.25rem * var(--tw-space-y-reverse));}'],
            ['-space-y-2', '.-space-y-2>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(-0.5rem * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(-0.5rem * var(--tw-space-y-reverse));}'],
        ];
    }

    #[DataProvider('arbitrarySpaceClassProvider')]
    public function testArbitrarySpaceClass(string $input, string $expected): void
    {
        $spaceClass = SpaceClass::parse($input);
        $this->assertInstanceOf(SpaceClass::class, $spaceClass);
        $this->assertSame($expected, $spaceClass->toCss());
    }

    public static function arbitrarySpaceClassProvider(): array
    {
        return [
            ['space-x-[5px]', '.space-x-\[5px\]>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(5px * var(--tw-space-x-reverse));margin-left:calc(5px * calc(1 - var(--tw-space-x-reverse)));}'],
            ['space-y-[2em]', '.space-y-\[2em\]>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(2em * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(2em * var(--tw-space-y-reverse));}'],
            ['-space-x-[10px]', '.-space-x-\[10px\]>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(-10px * var(--tw-space-x-reverse));margin-left:calc(-10px * calc(1 - var(--tw-space-x-reverse)));}'],
            ['-space-y-[3em]', '.-space-y-\[3em\]>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(-3em * calc(1 - var(--tw-space-y-reverse)));margin-bottom:calc(-3em * var(--tw-space-y-reverse));}'],
        ];
    }
}
