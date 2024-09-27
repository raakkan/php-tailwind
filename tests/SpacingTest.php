<?php

namespace Raakkan\PhpTailwind\Tests\Spacing;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Spacing\MarginClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\PaddingClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpaceClass;
use PHPUnit\Framework\Attributes\DataProvider;

class SpacingTest extends TestCase
{
    #[DataProvider('marginClassProvider')]
    public function testMarginClass(string $input, string $expected): void
    {
        $marginClass = MarginClass::parse($input);
        $this->assertInstanceOf(MarginClass::class, $marginClass);
        $this->assertSame($expected, $this->compress($marginClass->toCss()));
    }

    public static function marginClassProvider(): array
    {
        return [
            ['m-0', '.m-0{margin:0px;}'],
            ['m-px', '.m-px{margin:1px;}'],
            ['m-1', '.m-1{margin:0.25rem;}'],
            ['m-2', '.m-2{margin:0.5rem;}'],
            ['m-4', '.m-4{margin:1rem;}'],
            ['m-8', '.m-8{margin:2rem;}'],
            ['m-16', '.m-16{margin:4rem;}'],
            ['m-0.5', '.m-0.5{margin:0.125rem;}'],
            ['m-1.5', '.m-1.5{margin:0.375rem;}'],
            ['m-2.5', '.m-2.5{margin:0.625rem;}'],
            ['mt-4', '.mt-4{margin-top:1rem;}'],
            ['mr-4', '.mr-4{margin-right:1rem;}'],
            ['mb-4', '.mb-4{margin-bottom:1rem;}'],
            ['ml-4', '.ml-4{margin-left:1rem;}'],
            ['mx-4', '.mx-4{margin-left:1rem;margin-right:1rem;}'],
            ['my-4', '.my-4{margin-top:1rem;margin-bottom:1rem;}'],
            ['m-[10px]', '.m-\[10px\]{margin:10px;}'],
            ['m-[2rem]', '.m-\[2rem\]{margin:2rem;}'],
            ['m-1/2', '.m-1\/2{margin:50%;}'],
            ['m-1/3', '.m-1\/3{margin:33.333333%;}'],
            ['m-2/3', '.m-2\/3{margin:66.666667%;}'],
            ['-m-1', '.-m-1{margin:-0.25rem;}'],
            ['-m-2', '.-m-2{margin:-0.5rem;}'],
            ['-mt-4', '.-mt-4{margin-top:-1rem;}'],
            ['-mx-6', '.-mx-6{margin-left:-1.5rem;margin-right:-1.5rem;}'],
            ['m-auto', '.m-auto{margin:auto;}'],
            ['mx-auto', '.mx-auto{margin-left:auto;margin-right:auto;}'],
            ['my-auto', '.my-auto{margin-top:auto;margin-bottom:auto;}'],
            ['mt-auto', '.mt-auto{margin-top:auto;}'],
            ['mr-auto', '.mr-auto{margin-right:auto;}'],
            ['mb-auto', '.mb-auto{margin-bottom:auto;}'],
            ['ml-auto', '.ml-auto{margin-left:auto;}'],
            ['ms-4', '.ms-4{margin-inline-start:1rem;}'],
            ['me-4', '.me-4{margin-inline-end:1rem;}'],
            ['ms-auto', '.ms-auto{margin-inline-start:auto;}'],
            ['me-auto', '.me-auto{margin-inline-end:auto;}'],
            ['m-[10px]', '.m-\[10px\]{margin:10px;}'],
            ['m-[2rem]', '.m-\[2rem\]{margin:2rem;}'],
            ['mt-[5vh]', '.mt-\[5vh\]{margin-top:5vh;}'],
            ['mx-[10%]', '.mx-\[10\%\]{margin-left:10%;margin-right:10%;}'],
            ['my-[calc(100%-20px)]', '.my-\[calc\(100\%-20px\)\]{margin-top:calc(100%-20px);margin-bottom:calc(100%-20px);}'],
            ['-m-[10px]', '.-m-\[10px\]{margin:-10px;}'],
            ['-mt-[2rem]', '.-mt-\[2rem\]{margin-top:-2rem;}'],
            ['m-[20%]', '.m-\[20\%\]{margin:20%;}'],
            ['mx-[10%]', '.mx-\[10\%\]{margin-left:10%;margin-right:10%;}'],
        ];
    }

    #[DataProvider('paddingClassProvider')]
    public function testPaddingClass(string $input, string $expected): void
    {
        $paddingClass = PaddingClass::parse($input);
        $this->assertInstanceOf(PaddingClass::class, $paddingClass);
        $this->assertSame($expected, $this->compress($paddingClass->toCss()));
    }

    public static function paddingClassProvider(): array
    {
        return [
            ['p-0', '.p-0{padding:0px;}'],
            ['p-px', '.p-px{padding:1px;}'],
            ['p-1', '.p-1{padding:0.25rem;}'],
            ['p-2', '.p-2{padding:0.5rem;}'],
            ['p-4', '.p-4{padding:1rem;}'],
            ['p-8', '.p-8{padding:2rem;}'],
            ['p-16', '.p-16{padding:4rem;}'],
            ['p-0.5', '.p-0.5{padding:0.125rem;}'],
            ['p-1.5', '.p-1.5{padding:0.375rem;}'],
            ['p-2.5', '.p-2.5{padding:0.625rem;}'],
            ['pt-4', '.pt-4{padding-top:1rem;}'],
            ['pr-4', '.pr-4{padding-right:1rem;}'],
            ['pb-4', '.pb-4{padding-bottom:1rem;}'],
            ['pl-4', '.pl-4{padding-left:1rem;}'],
            ['px-4', '.px-4{padding-left:1rem;padding-right:1rem;}'],
            ['py-4', '.py-4{padding-top:1rem;padding-bottom:1rem;}'],
            ['p-[10px]', '.p-\[10px\]{padding:10px;}'],
            ['p-[2rem]', '.p-\[2rem\]{padding:2rem;}'],
            ['p-1/2', '.p-1\/2{padding:50%;}'],
            ['p-1/3', '.p-1\/3{padding:33.333333%;}'],
            ['p-2/3', '.p-2\/3{padding:66.666667%;}'],
            ['ps-4', '.ps-4{padding-inline-start:1rem;}'],
            ['pe-4', '.pe-4{padding-inline-end:1rem;}'],
        ];
    }

    #[DataProvider('spacingValueCalculatorProvider')]
    public function testSpacingValueCalculator(string $input, bool $isNegative, string $expected): void
    {
        $this->assertSame($expected, SpacingValueCalculator::calculate($input, $isNegative));
    }

    public static function spacingValueCalculatorProvider(): array
    {
        return [
            ['0', false, '0px'],
            ['px', false, '1px'],
            ['1', false, '0.25rem'],
            ['2', false, '0.5rem'],
            ['4', false, '1rem'],
            ['8', false, '2rem'],
            ['16', false, '4rem'],
            ['0.5', false, '0.125rem'],
            ['1.5', false, '0.375rem'],
            ['2.5', false, '0.625rem'],
            ['[10px]', false, '10px'],
            ['[2rem]', false, '2rem'],
            ['1/2', false, '50%'],
            ['1/3', false, '33.333333%'],
            ['2/3', false, '66.666667%'],
            ['1', true, '-0.25rem'],
            ['2', true, '-0.5rem'],
            ['4', true, '-1rem'],
            ['[10px]', true, '-10px'],
            ['1/2', true, '-50%'],
        ];
    }

    public function testInvalidMarginClass(): void
    {
        $this->assertNull(MarginClass::parse('invalid-class'));
    }

    public function testInvalidPaddingClass(): void
    {
        $this->assertNull(PaddingClass::parse('invalid-class'));
    }

    public function testMarginClassWithInvalidValue(): void
    {
        $marginClass = MarginClass::parse('m-invalid');
        $this->assertSame('.m-invalid{margin:invalid;}', $this->compress($marginClass->toCss()));
    }

    public function testPaddingClassWithInvalidValue(): void
    {
        $paddingClass = PaddingClass::parse('p-invalid');
        $this->assertSame('.p-invalid{padding:invalid;}', $this->compress($paddingClass->toCss()));
    }

    public function testNegativePaddingClass(): void
    {
        $this->assertNull(PaddingClass::parse('-p-1'));
        $this->assertNull(PaddingClass::parse('-pt-4'));
        $this->assertNull(PaddingClass::parse('-px-6'));
        $this->assertNull(PaddingClass::parse('-ps-4'));
        $this->assertNull(PaddingClass::parse('-pe-4'));
    }

    public function testAutoMarginClass(): void
    {
        $this->assertSame('.m-auto{margin:auto;}', $this->compress(MarginClass::parse('m-auto')->toCss()));
        $this->assertSame('.mx-auto{margin-left:auto;margin-right:auto;}', $this->compress(MarginClass::parse('mx-auto')->toCss()));
        $this->assertSame('.my-auto{margin-top:auto;margin-bottom:auto;}', $this->compress(MarginClass::parse('my-auto')->toCss()));
        $this->assertSame('.mt-auto{margin-top:auto;}', $this->compress(MarginClass::parse('mt-auto')->toCss()));
        $this->assertSame('.mr-auto{margin-right:auto;}', $this->compress(MarginClass::parse('mr-auto')->toCss()));
        $this->assertSame('.mb-auto{margin-bottom:auto;}', $this->compress(MarginClass::parse('mb-auto')->toCss()));
        $this->assertSame('.ml-auto{margin-left:auto;}', $this->compress(MarginClass::parse('ml-auto')->toCss()));
        $this->assertSame('.ms-auto{margin-inline-start:auto;}', $this->compress(MarginClass::parse('ms-auto')->toCss()));
        $this->assertSame('.me-auto{margin-inline-end:auto;}', $this->compress(MarginClass::parse('me-auto')->toCss()));
    }

    public function testInlineMarginAndPaddingClasses(): void
    {
        $this->assertSame('.ms-4{margin-inline-start:1rem;}', $this->compress(MarginClass::parse('ms-4')->toCss()));
        $this->assertSame('.me-4{margin-inline-end:1rem;}', $this->compress(MarginClass::parse('me-4')->toCss()));
        $this->assertSame('.ps-4{padding-inline-start:1rem;}', $this->compress(PaddingClass::parse('ps-4')->toCss()));
        $this->assertSame('.pe-4{padding-inline-end:1rem;}', $this->compress(PaddingClass::parse('pe-4')->toCss()));
    }

    #[DataProvider('spaceClassProvider')]
    public function testSpaceClass(string $input, string $expected): void
    {
        $spaceClass = SpaceClass::parse($input);
        $this->assertInstanceOf(SpaceClass::class, $spaceClass);
        $this->assertSame($expected, $this->compress($spaceClass->toCss()));
    }

    public static function spaceClassProvider(): array
    {
        return [
            ['space-x-4', '.space-x-4>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(1rem*var(--tw-space-x-reverse));margin-left:calc(1rem*calc(1-var(--tw-space-x-reverse)));}'],
            ['space-y-4', '.space-y-4>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-bottom:calc(1rem*var(--tw-space-y-reverse));margin-top:calc(1rem*calc(1-var(--tw-space-y-reverse)));}'],
            ['space-x-reverse', '.space-x-reverse>:not([hidden])~:not([hidden]){--tw-space-x-reverse:1;}'],
            ['space-y-reverse', '.space-y-reverse>:not([hidden])~:not([hidden]){--tw-space-y-reverse:1;}'],
            ['space-x-2', '.space-x-2>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(0.5rem*var(--tw-space-x-reverse));margin-left:calc(0.5rem*calc(1-var(--tw-space-x-reverse)));}'],
            ['space-y-8', '.space-y-8>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-bottom:calc(2rem*var(--tw-space-y-reverse));margin-top:calc(2rem*calc(1-var(--tw-space-y-reverse)));}'],
            ['space-x-[10px]', '.space-x-\[10px\]>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(10px*var(--tw-space-x-reverse));margin-left:calc(10px*calc(1-var(--tw-space-x-reverse)));}'],
            ['space-y-[2rem]', '.space-y-\[2rem\]>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-bottom:calc(2rem*var(--tw-space-y-reverse));margin-top:calc(2rem*calc(1-var(--tw-space-y-reverse)));}'],
            ['space-x-[5%]', '.space-x-\[5\%\]>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(5\%*var(--tw-space-x-reverse));margin-left:calc(5\%*calc(1-var(--tw-space-x-reverse)));}'],
            ['space-y-[calc(1rem+10px)]', '.space-y-\[calc\(1rem\+10px\)\]>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-bottom:calc(calc\(1rem\+10px\)*var(--tw-space-y-reverse));margin-top:calc(calc\(1rem\+10px\)*calc(1-var(--tw-space-y-reverse)));}'],
            ['space-x-[calc(100%-20px)]', '.space-x-\[calc\(100\%-20px\)\]>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(calc\(100\%-20px\)*var(--tw-space-x-reverse));margin-left:calc(calc\(100\%-20px\)*calc(1-var(--tw-space-x-reverse)));}'],
        ];
    }

    public function testInvalidSpaceClass(): void
    {
        $this->assertNull(SpaceClass::parse('invalid-space-class'));
    }

    public function testArbitrarySpaceClass(): void
    {
        $spaceClass = SpaceClass::parse('space-x-[15px]');
        $this->assertInstanceOf(SpaceClass::class, $spaceClass);
        $expected = '.space-x-\[15px\]>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(15px*var(--tw-space-x-reverse));margin-left:calc(15px*calc(1-var(--tw-space-x-reverse)));}';
        $this->assertSame($expected, $this->compress($spaceClass->toCss()));

        $spaceClass = SpaceClass::parse('space-y-[3vh]');
        $this->assertInstanceOf(SpaceClass::class, $spaceClass);
        $expected = '.space-y-\[3vh\]>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-bottom:calc(3vh*var(--tw-space-y-reverse));margin-top:calc(3vh*calc(1-var(--tw-space-y-reverse)));}';
        $this->assertSame($expected, $this->compress($spaceClass->toCss()));

        $spaceClass = SpaceClass::parse('space-x-[calc(100%-20px)]');
        $this->assertInstanceOf(SpaceClass::class, $spaceClass);
        $expected = '.space-x-\[calc\(100\%-20px\)\]>:not([hidden])~:not([hidden]){--tw-space-x-reverse:0;margin-right:calc(calc\(100\%-20px\)*var(--tw-space-x-reverse));margin-left:calc(calc\(100\%-20px\)*calc(1-var(--tw-space-x-reverse)));}';
        $this->assertSame($expected, $this->compress($spaceClass->toCss()));
    }

    public function testArbitraryMarginClass(): void
    {
        $marginClass = MarginClass::parse('m-[15px]');
        $this->assertInstanceOf(MarginClass::class, $marginClass);
        $expected = '.m-\[15px\]{margin:15px;}';
        $this->assertSame($expected, $this->compress($marginClass->toCss()));

        $marginClass = MarginClass::parse('mt-[3vh]');
        $this->assertInstanceOf(MarginClass::class, $marginClass);
        $expected = '.mt-\[3vh\]{margin-top:3vh;}';
        $this->assertSame($expected, $this->compress($marginClass->toCss()));

        $marginClass = MarginClass::parse('mx-[calc(100%-20px)]');
        $this->assertInstanceOf(MarginClass::class, $marginClass);
        $expected = '.mx-\[calc\(100\%-20px\)\]{margin-left:calc(100%-20px);margin-right:calc(100%-20px);}';
        $this->assertSame($expected, $this->compress($marginClass->toCss()));

        $marginClass = MarginClass::parse('m-[20%]');
        $this->assertInstanceOf(MarginClass::class, $marginClass);
        $expected = '.m-\[20\%\]{margin:20%;}';
        $this->assertSame($expected, $this->compress($marginClass->toCss()));
    }

    public function compress(string $css): string
    {
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        $css = preg_replace('/\s+/', '', $css);
        return $css;
    }
}