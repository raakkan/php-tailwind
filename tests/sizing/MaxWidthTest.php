<?php

namespace Raakkan\PhpTailwind\Tests\Sizing;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Sizing\MaxWidthClass;

class MaxWidthTest extends TestCase
{
    #[DataProvider('maxWidthClassProvider')]
    public function test_max_width_class(string $input, string $expected): void
    {
        $maxWidthClass = MaxWidthClass::parse($input);
        $this->assertInstanceOf(MaxWidthClass::class, $maxWidthClass);
        $this->assertSame($expected, $maxWidthClass->toCss());
    }

    public static function maxWidthClassProvider(): array
    {
        return [
            // Core values
            ['max-w-0', '.max-w-0{max-width:0px;}'],
            ['max-w-none', '.max-w-none{max-width:none;}'],
            ['max-w-full', '.max-w-full{max-width:100%;}'],
            ['max-w-min', '.max-w-min{max-width:min-content;}'],
            ['max-w-max', '.max-w-max{max-width:max-content;}'],
            ['max-w-fit', '.max-w-fit{max-width:fit-content;}'],
            ['max-w-prose', '.max-w-prose{max-width:65ch;}'],

            // Named sizes
            ['max-w-xs', '.max-w-xs{max-width:20rem;}'],
            ['max-w-sm', '.max-w-sm{max-width:24rem;}'],
            ['max-w-md', '.max-w-md{max-width:28rem;}'],
            ['max-w-lg', '.max-w-lg{max-width:32rem;}'],
            ['max-w-xl', '.max-w-xl{max-width:36rem;}'],
            ['max-w-2xl', '.max-w-2xl{max-width:42rem;}'],
            ['max-w-3xl', '.max-w-3xl{max-width:48rem;}'],
            ['max-w-4xl', '.max-w-4xl{max-width:56rem;}'],
            ['max-w-5xl', '.max-w-5xl{max-width:64rem;}'],
            ['max-w-6xl', '.max-w-6xl{max-width:72rem;}'],
            ['max-w-7xl', '.max-w-7xl{max-width:80rem;}'],

            // Screen sizes
            ['max-w-screen-sm', '.max-w-screen-sm{max-width:640px;}'],
            ['max-w-screen-md', '.max-w-screen-md{max-width:768px;}'],
            ['max-w-screen-lg', '.max-w-screen-lg{max-width:1024px;}'],
            ['max-w-screen-xl', '.max-w-screen-xl{max-width:1280px;}'],
            ['max-w-screen-2xl', '.max-w-screen-2xl{max-width:1536px;}'],

            // Numeric values (spacing scale)
            ['max-w-px', '.max-w-px{max-width:1px;}'],
            ['max-w-0', '.max-w-0{max-width:0px;}'],
            ['max-w-0.5', '.max-w-0\.5{max-width:0.125rem;}'],
            ['max-w-1', '.max-w-1{max-width:0.25rem;}'],
            ['max-w-1.5', '.max-w-1\.5{max-width:0.375rem;}'],
            ['max-w-2', '.max-w-2{max-width:0.5rem;}'],
            ['max-w-2.5', '.max-w-2\.5{max-width:0.625rem;}'],
            ['max-w-3', '.max-w-3{max-width:0.75rem;}'],
            ['max-w-3.5', '.max-w-3\.5{max-width:0.875rem;}'],
            ['max-w-4', '.max-w-4{max-width:1rem;}'],
            ['max-w-5', '.max-w-5{max-width:1.25rem;}'],
            ['max-w-6', '.max-w-6{max-width:1.5rem;}'],
            ['max-w-7', '.max-w-7{max-width:1.75rem;}'],
            ['max-w-8', '.max-w-8{max-width:2rem;}'],
            ['max-w-9', '.max-w-9{max-width:2.25rem;}'],
            ['max-w-10', '.max-w-10{max-width:2.5rem;}'],
            ['max-w-11', '.max-w-11{max-width:2.75rem;}'],
            ['max-w-12', '.max-w-12{max-width:3rem;}'],
            ['max-w-14', '.max-w-14{max-width:3.5rem;}'],
            ['max-w-16', '.max-w-16{max-width:4rem;}'],
            ['max-w-20', '.max-w-20{max-width:5rem;}'],
            ['max-w-24', '.max-w-24{max-width:6rem;}'],
            ['max-w-28', '.max-w-28{max-width:7rem;}'],
            ['max-w-32', '.max-w-32{max-width:8rem;}'],
            ['max-w-36', '.max-w-36{max-width:9rem;}'],
            ['max-w-40', '.max-w-40{max-width:10rem;}'],
            ['max-w-44', '.max-w-44{max-width:11rem;}'],
            ['max-w-48', '.max-w-48{max-width:12rem;}'],
            ['max-w-52', '.max-w-52{max-width:13rem;}'],
            ['max-w-56', '.max-w-56{max-width:14rem;}'],
            ['max-w-60', '.max-w-60{max-width:15rem;}'],
            ['max-w-64', '.max-w-64{max-width:16rem;}'],
            ['max-w-72', '.max-w-72{max-width:18rem;}'],
            ['max-w-80', '.max-w-80{max-width:20rem;}'],
            ['max-w-96', '.max-w-96{max-width:24rem;}'],

            // Arbitrary values
            ['max-w-[100px]', '.max-w-\[100px\]{max-width:100px;}'],
            ['max-w-[20%]', '.max-w-\[20\%\]{max-width:20%;}'],
            ['max-w-[500px]', '.max-w-\[500px\]{max-width:500px;}'],
            ['max-w-[23rem]', '.max-w-\[23rem\]{max-width:23rem;}'],
            ['max-w-[calc(100%-2rem)]', '.max-w-\[calc\(100\%-2rem\)\]{max-width:calc(100%-2rem);}'],
            ['max-w-[clamp(200px,50%,300px)]', '.max-w-\[clamp\(200px\2c 50\%\2c 300px\)\]{max-width:clamp(200px,50%,300px);}'],
        ];
    }

    public function test_invalid_max_width_class(): void
    {
        $this->assertNull(MaxWidthClass::parse('invalid-class'));
    }

    public function test_max_width_class_with_invalid_value(): void
    {
        $maxWidthClass = MaxWidthClass::parse('max-w-invalid');
        $this->assertInstanceOf(MaxWidthClass::class, $maxWidthClass);
        $this->assertSame('', $maxWidthClass->toCss());
    }

    #[DataProvider('invalidArbitraryMaxWidthProvider')]
    public function test_invalid_arbitrary_max_width(string $input): void
    {
        $maxWidthClass = MaxWidthClass::parse($input);
        $this->assertInstanceOf(MaxWidthClass::class, $maxWidthClass);
        $this->assertSame('', $maxWidthClass->toCss());
    }

    public static function invalidArbitraryMaxWidthProvider(): array
    {
        return [
            ['max-w-[invalid]'],
            ['max-w-[10]'],
            ['max-w-[rem]'],
            ['max-w-[calc()]'],
            ['max-w-[]'],
            ['max-w-[.]'],
        ];
    }

    #[DataProvider('validArbitraryMaxWidthProvider')]
    public function test_valid_arbitrary_max_width(string $input, string $expected): void
    {
        $maxWidthClass = MaxWidthClass::parse($input);
        $this->assertInstanceOf(MaxWidthClass::class, $maxWidthClass);
        $this->assertSame($expected, $maxWidthClass->toCss());
    }

    public static function validArbitraryMaxWidthProvider(): array
    {
        return [
            ['max-w-[100px]', '.max-w-\[100px\]{max-width:100px;}'],
            ['max-w-[13.5rem]', '.max-w-\[13\.5rem\]{max-width:13.5rem;}'],
            ['max-w-[50%]', '.max-w-\[50\%\]{max-width:50%;}'],
            ['max-w-[calc(100%-1rem)]', '.max-w-\[calc\(100\%-1rem\)\]{max-width:calc(100%-1rem);}'],
            ['max-w-[clamp(200px,50%,300px)]', '.max-w-\[clamp\(200px\2c 50\%\2c 300px\)\]{max-width:clamp(200px,50%,300px);}'],
            ['max-w-[max(50%,300px)]', '.max-w-\[max\(50\%\2c 300px\)\]{max-width:max(50%,300px);}'],
            ['max-w-[min(50%,300px)]', '.max-w-\[min\(50\%\2c 300px\)\]{max-width:min(50%,300px);}'],
        ];
    }
}
