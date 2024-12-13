<?php

namespace Raakkan\PhpTailwind\Tests\Interactivity;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Interactivity\ScrollMarginClass;

class ScrollMarginTest extends TestCase
{
    #[DataProvider('scrollMarginClassProvider')]
    public function test_scroll_margin_class(string $input, string $expected): void
    {
        $scrollMarginClass = ScrollMarginClass::parse($input);
        $this->assertInstanceOf(ScrollMarginClass::class, $scrollMarginClass);
        $this->assertSame($expected, $scrollMarginClass->toCss());
    }

    public static function scrollMarginClassProvider(): array
    {
        return [
            ['scroll-m-0', '.scroll-m-0{scroll-margin:0px;}'],
            ['scroll-m-px', '.scroll-m-px{scroll-margin:1px;}'],
            ['scroll-m-0.5', '.scroll-m-0\.5{scroll-margin:0.125rem;}'],
            ['scroll-m-1', '.scroll-m-1{scroll-margin:0.25rem;}'],
            ['scroll-m-2', '.scroll-m-2{scroll-margin:0.5rem;}'],
            ['scroll-m-4', '.scroll-m-4{scroll-margin:1rem;}'],
            ['scroll-m-8', '.scroll-m-8{scroll-margin:2rem;}'],
            ['scroll-m-16', '.scroll-m-16{scroll-margin:4rem;}'],
            ['scroll-m-32', '.scroll-m-32{scroll-margin:8rem;}'],
            ['scroll-m-64', '.scroll-m-64{scroll-margin:16rem;}'],
            ['scroll-mt-4', '.scroll-mt-4{scroll-margin-top:1rem;}'],
            ['scroll-mr-4', '.scroll-mr-4{scroll-margin-right:1rem;}'],
            ['scroll-mb-4', '.scroll-mb-4{scroll-margin-bottom:1rem;}'],
            ['scroll-ml-4', '.scroll-ml-4{scroll-margin-left:1rem;}'],
            ['scroll-mx-4', '.scroll-mx-4{scroll-margin-left:1rem;scroll-margin-right:1rem;}'],
            ['scroll-my-4', '.scroll-my-4{scroll-margin-top:1rem;scroll-margin-bottom:1rem;}'],
            ['-scroll-m-4', '.-scroll-m-4{scroll-margin:-1rem;}'],
            ['-scroll-mt-4', '.-scroll-mt-4{scroll-margin-top:-1rem;}'],
            ['-scroll-mr-4', '.-scroll-mr-4{scroll-margin-right:-1rem;}'],
            ['-scroll-mb-4', '.-scroll-mb-4{scroll-margin-bottom:-1rem;}'],
            ['-scroll-ml-4', '.-scroll-ml-4{scroll-margin-left:-1rem;}'],
            ['-scroll-mx-4', '.-scroll-mx-4{scroll-margin-left:-1rem;scroll-margin-right:-1rem;}'],
            ['-scroll-my-4', '.-scroll-my-4{scroll-margin-top:-1rem;scroll-margin-bottom:-1rem;}'],
        ];
    }

    public function test_invalid_scroll_margin_class(): void
    {
        $this->assertNull(ScrollMarginClass::parse('invalid-class'));
    }

    public function test_scroll_margin_class_with_invalid_value(): void
    {
        $scrollMarginClass = ScrollMarginClass::parse('scroll-m-invalid');
        $this->assertInstanceOf(ScrollMarginClass::class, $scrollMarginClass);
        $this->assertSame('', $scrollMarginClass->toCss());
    }

    #[DataProvider('inlineScrollMarginClassProvider')]
    public function test_inline_scroll_margin_classes(string $input, string $expected): void
    {
        $scrollMarginClass = ScrollMarginClass::parse($input);
        $this->assertInstanceOf(ScrollMarginClass::class, $scrollMarginClass);
        $this->assertSame($expected, $scrollMarginClass->toCss());
    }

    public static function inlineScrollMarginClassProvider(): array
    {
        return [
            ['scroll-ms-4', '.scroll-ms-4{scroll-margin-inline-start:1rem;}'],
            ['scroll-me-4', '.scroll-me-4{scroll-margin-inline-end:1rem;}'],
            ['-scroll-ms-4', '.-scroll-ms-4{scroll-margin-inline-start:-1rem;}'],
            ['-scroll-me-4', '.-scroll-me-4{scroll-margin-inline-end:-1rem;}'],
        ];
    }

    #[DataProvider('arbitraryScrollMarginClassProvider')]
    public function test_arbitrary_scroll_margin_class(string $input, string $expected): void
    {
        $scrollMarginClass = ScrollMarginClass::parse($input);
        $this->assertInstanceOf(ScrollMarginClass::class, $scrollMarginClass);
        $this->assertSame($expected, $scrollMarginClass->toCss());
    }

    public static function arbitraryScrollMarginClassProvider(): array
    {
        return [
            ['scroll-m-[10px]', '.scroll-m-\[10px\]{scroll-margin:10px;}'],
            ['scroll-mt-[2em]', '.scroll-mt-\[2em\]{scroll-margin-top:2em;}'],
            ['scroll-mr-[10vh]', '.scroll-mr-\[10vh\]{scroll-margin-right:10vh;}'],
            ['scroll-mb-[10%]', '.scroll-mb-\[10\%\]{scroll-margin-bottom:10%;}'],
            ['scroll-mx-[10px]', '.scroll-mx-\[10px\]{scroll-margin-left:10px;scroll-margin-right:10px;}'],
            ['scroll-my-[2em]', '.scroll-my-\[2em\]{scroll-margin-top:2em;scroll-margin-bottom:2em;}'],
            ['-scroll-m-[10px]', '.-scroll-m-\[10px\]{scroll-margin:-10px;}'],
            ['-scroll-mt-[2em]', '.-scroll-mt-\[2em\]{scroll-margin-top:-2em;}'],
            ['scroll-ms-[10px]', '.scroll-ms-\[10px\]{scroll-margin-inline-start:10px;}'],
            ['scroll-me-[2em]', '.scroll-me-\[2em\]{scroll-margin-inline-end:2em;}'],
        ];
    }

    #[DataProvider('fractionScrollMarginClassProvider')]
    public function test_fraction_scroll_margin_class(string $input, string $expected): void
    {
        $scrollMarginClass = ScrollMarginClass::parse($input);
        $this->assertInstanceOf(ScrollMarginClass::class, $scrollMarginClass);
        $this->assertSame($expected, $scrollMarginClass->toCss());
    }

    public static function fractionScrollMarginClassProvider(): array
    {
        return [
            ['scroll-m-1/2', '.scroll-m-1\/2{scroll-margin:50%;}'],
            ['scroll-mt-2/3', '.scroll-mt-2\/3{scroll-margin-top:66.666667%;}'],
            ['scroll-mr-3/4', '.scroll-mr-3\/4{scroll-margin-right:75%;}'],
            ['scroll-mb-1/5', '.scroll-mb-1\/5{scroll-margin-bottom:20%;}'],
            ['scroll-ml-2/5', '.scroll-ml-2\/5{scroll-margin-left:40%;}'],
            ['scroll-mx-3/5', '.scroll-mx-3\/5{scroll-margin-left:60%;scroll-margin-right:60%;}'],
            ['scroll-my-4/5', '.scroll-my-4\/5{scroll-margin-top:80%;scroll-margin-bottom:80%;}'],
            ['-scroll-m-1/2', '.-scroll-m-1\/2{scroll-margin:-50%;}'],
            ['-scroll-mt-2/3', '.-scroll-mt-2\/3{scroll-margin-top:-66.666667%;}'],
        ];
    }

    #[DataProvider('invalidArbitraryScrollMarginClassProvider')]
    public function test_invalid_arbitrary_scroll_margin_class(string $input): void
    {
        $scrollMarginClass = ScrollMarginClass::parse($input);
        $this->assertInstanceOf(ScrollMarginClass::class, $scrollMarginClass);
        $this->assertSame('', $scrollMarginClass->toCss());
    }

    public static function invalidArbitraryScrollMarginClassProvider(): array
    {
        return [
            ['scroll-m-[invalid]'],
            // ['scroll-mt-[10]'],
            ['scroll-mr-[em]'],
            ['scroll-mb-[]'],
            ['scroll-ml-[10px'],
            ['scroll-mx-10px]'],
        ];
    }
}
