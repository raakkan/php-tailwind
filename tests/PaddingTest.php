<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Spacing\PaddingClass;

class PaddingTest extends TestCase
{
    #[DataProvider('paddingClassProvider')]
    public function test_padding_class(string $input, string $expected): void
    {
        $paddingClass = PaddingClass::parse($input);
        $this->assertInstanceOf(PaddingClass::class, $paddingClass);
        $this->assertSame($expected, $paddingClass->toCss());
    }

    public static function paddingClassProvider(): array
    {
        return [
            ['p-0', '.p-0{padding:0px;}'],
            ['p-px', '.p-px{padding:1px;}'],
            ['p-0.5', '.p-0\.5{padding:0.125rem;}'],
            ['p-1', '.p-1{padding:0.25rem;}'],
            ['p-2', '.p-2{padding:0.5rem;}'],
            ['p-4', '.p-4{padding:1rem;}'],
            ['p-8', '.p-8{padding:2rem;}'],
            ['p-16', '.p-16{padding:4rem;}'],
            ['p-32', '.p-32{padding:8rem;}'],
            ['p-64', '.p-64{padding:16rem;}'],
            ['pt-4', '.pt-4{padding-top:1rem;}'],
            ['pr-4', '.pr-4{padding-right:1rem;}'],
            ['pb-4', '.pb-4{padding-bottom:1rem;}'],
            ['pl-4', '.pl-4{padding-left:1rem;}'],
            ['px-4', '.px-4{padding-left:1rem;padding-right:1rem;}'],
            ['py-4', '.py-4{padding-top:1rem;padding-bottom:1rem;}'],
        ];
    }

    public function test_invalid_padding_class(): void
    {
        $this->assertNull(PaddingClass::parse('invalid-class'));
    }

    public function test_padding_class_with_invalid_value(): void
    {
        $paddingClass = PaddingClass::parse('p-invalid');
        $this->assertInstanceOf(PaddingClass::class, $paddingClass);
        $this->assertSame('', $paddingClass->toCss());
    }

    #[DataProvider('negativePaddingClassProvider')]
    public function test_negative_padding_class(string $input): void
    {
        $this->assertNull(PaddingClass::parse($input));
    }

    public static function negativePaddingClassProvider(): array
    {
        return [
            ['-p-1'],
            ['-pt-4'],
            ['-pr-4'],
            ['-pb-4'],
            ['-pl-4'],
            ['-px-4'],
            ['-py-4'],
        ];
    }

    #[DataProvider('inlinePaddingClassProvider')]
    public function test_inline_padding_classes(string $input, string $expected): void
    {
        $paddingClass = PaddingClass::parse($input);
        $this->assertInstanceOf(PaddingClass::class, $paddingClass);
        $this->assertSame($expected, $paddingClass->toCss());
    }

    public static function inlinePaddingClassProvider(): array
    {
        return [
            ['ps-4', '.ps-4{padding-inline-start:1rem;}'],
            ['pe-4', '.pe-4{padding-inline-end:1rem;}'],
        ];
    }

    #[DataProvider('arbitraryPaddingClassProvider')]
    public function test_arbitrary_padding_class(string $input, string $expected): void
    {
        $paddingClass = PaddingClass::parse($input);
        $this->assertInstanceOf(PaddingClass::class, $paddingClass);
        $this->assertSame($expected, $paddingClass->toCss());
    }

    public static function arbitraryPaddingClassProvider(): array
    {
        return [
            ['p-[10px]', '.p-\[10px\]{padding:10px;}'],
            ['pt-[2em]', '.pt-\[2em\]{padding-top:2em;}'],
            ['pr-[10vh]', '.pr-\[10vh\]{padding-right:10vh;}'],
            ['pb-[10%]', '.pb-\[10\%\]{padding-bottom:10%;}'],
            ['px-[10px]', '.px-\[10px\]{padding-left:10px;padding-right:10px;}'],
            ['py-[2em]', '.py-\[2em\]{padding-top:2em;padding-bottom:2em;}'],
            ['ps-[10px]', '.ps-\[10px\]{padding-inline-start:10px;}'],
            ['pe-[2em]', '.pe-\[2em\]{padding-inline-end:2em;}'],
        ];
    }
}
