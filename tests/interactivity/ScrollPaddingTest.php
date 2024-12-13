<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Interactivity\ScrollPaddingClass;

class ScrollPaddingTest extends TestCase
{
    #[DataProvider('scrollPaddingClassProvider')]
    public function test_scroll_padding_class(string $input, string $expected): void
    {
        $scrollPaddingClass = ScrollPaddingClass::parse($input);
        $this->assertInstanceOf(ScrollPaddingClass::class, $scrollPaddingClass);
        $this->assertSame($expected, $scrollPaddingClass->toCss());
    }

    public static function scrollPaddingClassProvider(): array
    {
        return [
            ['scroll-p-0', '.scroll-p-0{scroll-padding:0px;}'],
            ['scroll-p-px', '.scroll-p-px{scroll-padding:1px;}'],
            ['scroll-p-0.5', '.scroll-p-0\.5{scroll-padding:0.125rem;}'],
            ['scroll-p-1', '.scroll-p-1{scroll-padding:0.25rem;}'],
            ['scroll-p-2', '.scroll-p-2{scroll-padding:0.5rem;}'],
            ['scroll-p-4', '.scroll-p-4{scroll-padding:1rem;}'],
            ['scroll-p-8', '.scroll-p-8{scroll-padding:2rem;}'],
            ['scroll-p-16', '.scroll-p-16{scroll-padding:4rem;}'],
            ['scroll-p-32', '.scroll-p-32{scroll-padding:8rem;}'],
            ['scroll-p-64', '.scroll-p-64{scroll-padding:16rem;}'],
            ['scroll-p-96', '.scroll-p-96{scroll-padding:24rem;}'],
            ['scroll-pt-4', '.scroll-pt-4{scroll-padding-top:1rem;}'],
            ['scroll-pr-4', '.scroll-pr-4{scroll-padding-right:1rem;}'],
            ['scroll-pb-4', '.scroll-pb-4{scroll-padding-bottom:1rem;}'],
            ['scroll-pl-4', '.scroll-pl-4{scroll-padding-left:1rem;}'],
            ['scroll-px-4', '.scroll-px-4{scroll-padding-left:1rem;scroll-padding-right:1rem;}'],
            ['scroll-py-4', '.scroll-py-4{scroll-padding-top:1rem;scroll-padding-bottom:1rem;}'],
            ['scroll-ps-4', '.scroll-ps-4{scroll-padding-inline-start:1rem;}'],
            ['scroll-pe-4', '.scroll-pe-4{scroll-padding-inline-end:1rem;}'],
        ];
    }

    #[DataProvider('scrollPaddingFractionClassProvider')]
    public function test_scroll_padding_fraction_class(string $input, string $expected): void
    {
        $scrollPaddingClass = ScrollPaddingClass::parse($input);
        $this->assertInstanceOf(ScrollPaddingClass::class, $scrollPaddingClass);
        $this->assertSame($expected, $scrollPaddingClass->toCss());
    }

    public static function scrollPaddingFractionClassProvider(): array
    {
        return [
            ['scroll-p-1/2', '.scroll-p-1\/2{scroll-padding:50%;}'],
            ['scroll-p-2/3', '.scroll-p-2\/3{scroll-padding:66.666667%;}'],
            ['scroll-pt-1/4', '.scroll-pt-1\/4{scroll-padding-top:25%;}'],
            ['scroll-pr-3/4', '.scroll-pr-3\/4{scroll-padding-right:75%;}'],
        ];
    }

    #[DataProvider('scrollPaddingArbitraryValueProvider')]
    public function test_scroll_padding_arbitrary_value(string $input, string $expected): void
    {
        $scrollPaddingClass = ScrollPaddingClass::parse($input);
        $this->assertInstanceOf(ScrollPaddingClass::class, $scrollPaddingClass);
        $this->assertSame($expected, $scrollPaddingClass->toCss());
    }

    public static function scrollPaddingArbitraryValueProvider(): array
    {
        return [
            ['scroll-p-[10px]', '.scroll-p-\[10px\]{scroll-padding:10px;}'],
            ['scroll-pt-[2em]', '.scroll-pt-\[2em\]{scroll-padding-top:2em;}'],
            ['scroll-pr-[10vh]', '.scroll-pr-\[10vh\]{scroll-padding-right:10vh;}'],
            ['scroll-pb-[10%]', '.scroll-pb-\[10\%\]{scroll-padding-bottom:10%;}'],
            ['scroll-px-[10px]', '.scroll-px-\[10px\]{scroll-padding-left:10px;scroll-padding-right:10px;}'],
            ['scroll-py-[2em]', '.scroll-py-\[2em\]{scroll-padding-top:2em;scroll-padding-bottom:2em;}'],
            ['scroll-ps-[10px]', '.scroll-ps-\[10px\]{scroll-padding-inline-start:10px;}'],
            ['scroll-pe-[2em]', '.scroll-pe-\[2em\]{scroll-padding-inline-end:2em;}'],
            ['scroll-p-[calc(100%-2rem)]', '.scroll-p-\[calc\(100\%-2rem\)\]{scroll-padding:calc(100%-2rem);}'],
        ];
    }

    public function test_invalid_scroll_padding_class(): void
    {
        $this->assertNull(ScrollPaddingClass::parse('invalid-class'));
    }

    public function test_scroll_padding_class_with_invalid_value(): void
    {
        $scrollPaddingClass = ScrollPaddingClass::parse('scroll-p-invalid');
        $this->assertInstanceOf(ScrollPaddingClass::class, $scrollPaddingClass);
        $this->assertSame('', $scrollPaddingClass->toCss());
    }

    #[DataProvider('negativeScrollPaddingClassProvider')]
    public function test_negative_scroll_padding_class(string $input): void
    {
        $this->assertNull(ScrollPaddingClass::parse($input));
    }

    public static function negativeScrollPaddingClassProvider(): array
    {
        return [
            ['-scroll-p-1'],
            ['-scroll-pt-4'],
            ['-scroll-pr-4'],
            ['-scroll-pb-4'],
            ['-scroll-pl-4'],
            ['-scroll-px-4'],
            ['-scroll-py-4'],
        ];
    }

    #[DataProvider('invalidArbitraryScrollPaddingClassProvider')]
    public function test_invalid_arbitrary_scroll_padding_class(string $input): void
    {
        $scrollPaddingClass = ScrollPaddingClass::parse($input);
        $this->assertInstanceOf(ScrollPaddingClass::class, $scrollPaddingClass);
        $this->assertSame('', $scrollPaddingClass->toCss());
    }

    public static function invalidArbitraryScrollPaddingClassProvider(): array
    {
        return [
            ['scroll-p-[invalid]'],
            // ['scroll-pt-[10]'],
            ['scroll-pr-[em]'],
            // ['scroll-pb-[calc()]'],
            ['scroll-px-[var(--invalid)]'],
        ];
    }
}
