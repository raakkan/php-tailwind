<?php

namespace Raakkan\PhpTailwind\Tests\Sizing;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Sizing\SizeClass;

class SizeTest extends TestCase
{
    #[DataProvider('sizeClassProvider')]
    public function test_size_class(string $input, string $expected): void
    {
        $sizeClass = SizeClass::parse($input);
        $this->assertInstanceOf(SizeClass::class, $sizeClass);
        $this->assertSame($expected, $sizeClass->toCss());
    }

    public static function sizeClassProvider(): array
    {
        return [
            // Core values
            ['size-auto', '.size-auto{width:auto;height:auto;}'],
            ['size-px', '.size-px{width:1px;height:1px;}'],
            ['size-full', '.size-full{width:100%;height:100%;}'],
            ['size-screen', '.size-screen{width:100vw;height:100vw;}'],
            ['size-svw', '.size-svw{width:100svw;height:100svw;}'],
            ['size-lvw', '.size-lvw{width:100lvw;height:100lvw;}'],
            ['size-dvw', '.size-dvw{width:100dvw;height:100dvw;}'],
            ['size-min', '.size-min{width:min-content;height:min-content;}'],
            ['size-max', '.size-max{width:max-content;height:max-content;}'],
            ['size-fit', '.size-fit{width:fit-content;height:fit-content;}'],

            // Spacing scale values
            ['size-0', '.size-0{width:0px;height:0px;}'],
            ['size-0.5', '.size-0\.5{width:0.125rem;height:0.125rem;}'],
            ['size-1', '.size-1{width:0.25rem;height:0.25rem;}'],
            ['size-1.5', '.size-1\.5{width:0.375rem;height:0.375rem;}'],
            ['size-2', '.size-2{width:0.5rem;height:0.5rem;}'],
            ['size-2.5', '.size-2\.5{width:0.625rem;height:0.625rem;}'],
            ['size-3', '.size-3{width:0.75rem;height:0.75rem;}'],
            ['size-3.5', '.size-3\.5{width:0.875rem;height:0.875rem;}'],
            ['size-4', '.size-4{width:1rem;height:1rem;}'],
            ['size-5', '.size-5{width:1.25rem;height:1.25rem;}'],
            ['size-6', '.size-6{width:1.5rem;height:1.5rem;}'],
            ['size-7', '.size-7{width:1.75rem;height:1.75rem;}'],
            ['size-8', '.size-8{width:2rem;height:2rem;}'],
            ['size-9', '.size-9{width:2.25rem;height:2.25rem;}'],
            ['size-10', '.size-10{width:2.5rem;height:2.5rem;}'],
            ['size-11', '.size-11{width:2.75rem;height:2.75rem;}'],
            ['size-12', '.size-12{width:3rem;height:3rem;}'],
            ['size-14', '.size-14{width:3.5rem;height:3.5rem;}'],
            ['size-16', '.size-16{width:4rem;height:4rem;}'],
            ['size-20', '.size-20{width:5rem;height:5rem;}'],
            ['size-24', '.size-24{width:6rem;height:6rem;}'],
            ['size-28', '.size-28{width:7rem;height:7rem;}'],
            ['size-32', '.size-32{width:8rem;height:8rem;}'],
            ['size-36', '.size-36{width:9rem;height:9rem;}'],
            ['size-40', '.size-40{width:10rem;height:10rem;}'],
            ['size-44', '.size-44{width:11rem;height:11rem;}'],
            ['size-48', '.size-48{width:12rem;height:12rem;}'],
            ['size-52', '.size-52{width:13rem;height:13rem;}'],
            ['size-56', '.size-56{width:14rem;height:14rem;}'],
            ['size-60', '.size-60{width:15rem;height:15rem;}'],
            ['size-64', '.size-64{width:16rem;height:16rem;}'],
            ['size-72', '.size-72{width:18rem;height:18rem;}'],
            ['size-80', '.size-80{width:20rem;height:20rem;}'],
            ['size-96', '.size-96{width:24rem;height:24rem;}'],

            // Fractional values
            ['size-1/2', '.size-1\/2{width:50%;height:50%;}'],
            ['size-1/3', '.size-1\/3{width:33.333333%;height:33.333333%;}'],
            ['size-2/3', '.size-2\/3{width:66.666667%;height:66.666667%;}'],
            ['size-1/4', '.size-1\/4{width:25%;height:25%;}'],
            ['size-2/4', '.size-2\/4{width:50%;height:50%;}'],
            ['size-3/4', '.size-3\/4{width:75%;height:75%;}'],
            ['size-1/5', '.size-1\/5{width:20%;height:20%;}'],
            ['size-2/5', '.size-2\/5{width:40%;height:40%;}'],
            ['size-3/5', '.size-3\/5{width:60%;height:60%;}'],
            ['size-4/5', '.size-4\/5{width:80%;height:80%;}'],
            ['size-1/6', '.size-1\/6{width:16.666667%;height:16.666667%;}'],
            ['size-2/6', '.size-2\/6{width:33.333333%;height:33.333333%;}'],
            ['size-3/6', '.size-3\/6{width:50%;height:50%;}'],
            ['size-4/6', '.size-4\/6{width:66.666667%;height:66.666667%;}'],
            ['size-5/6', '.size-5\/6{width:83.333333%;height:83.333333%;}'],

            // Arbitrary values
            ['size-[10px]', '.size-\[10px\]{width:10px;height:10px;}'],
            ['size-[2rem]', '.size-\[2rem\]{width:2rem;height:2rem;}'],
            ['size-[50%]', '.size-\[50\%\]{width:50%;height:50%;}'],
            ['size-[100vh]', '.size-\[100vh\]{width:100vh;height:100vh;}'],
            ['size-[calc(100%-1rem)]', '.size-\[calc\(100\%-1rem\)\]{width:calc(100%-1rem);height:calc(100%-1rem);}'],
            ['size-[clamp(200px,50%,300px)]', '.size-\[clamp\(200px\2c 50\%\2c 300px\)\]{width:clamp(200px,50%,300px);height:clamp(200px,50%,300px);}'],
        ];
    }

    public function test_invalid_size_class(): void
    {
        $this->assertNull(SizeClass::parse('invalid-class'));
    }

    public function test_size_class_with_invalid_value(): void
    {
        $sizeClass = SizeClass::parse('size-invalid');
        $this->assertInstanceOf(SizeClass::class, $sizeClass);
        $this->assertSame('', $sizeClass->toCss());
    }

    #[DataProvider('invalidArbitrarySizeProvider')]
    public function test_invalid_arbitrary_size(string $input): void
    {
        $sizeClass = SizeClass::parse($input);
        $this->assertInstanceOf(SizeClass::class, $sizeClass);
        $this->assertSame('', $sizeClass->toCss());
    }

    public static function invalidArbitrarySizeProvider(): array
    {
        return [
            ['size-[invalid]'],
            ['size-[10]'],
            ['size-[rem]'],
            ['size-[calc()]'],
            ['size-[]'],
            ['size-[.]'],
        ];
    }

    #[DataProvider('validArbitrarySizeProvider')]
    public function test_valid_arbitrary_size(string $input, string $expected): void
    {
        $sizeClass = SizeClass::parse($input);
        $this->assertInstanceOf(SizeClass::class, $sizeClass);
        $this->assertSame($expected, $sizeClass->toCss());
    }

    public static function validArbitrarySizeProvider(): array
    {
        return [
            ['size-[100px]', '.size-\[100px\]{width:100px;height:100px;}'],
            ['size-[13.5rem]', '.size-\[13\.5rem\]{width:13.5rem;height:13.5rem;}'],
            ['size-[-25%]', '.size-\[-25\%\]{width:-25%;height:-25%;}'],
            ['size-[calc(100%+1rem)]', '.size-\[calc\(100\%\+1rem\)\]{width:calc(100%+1rem);height:calc(100%+1rem);}'],
            ['size-[clamp(200px,50%,300px)]', '.size-\[clamp\(200px\2c 50\%\2c 300px\)\]{width:clamp(200px,50%,300px);height:clamp(200px,50%,300px);}'],
            ['size-[max(50%,300px)]', '.size-\[max\(50\%\2c 300px\)\]{width:max(50%,300px);height:max(50%,300px);}'],
            ['size-[min(50%,300px)]', '.size-\[min\(50\%\2c 300px\)\]{width:min(50%,300px);height:min(50%,300px);}'],
        ];
    }

    #[DataProvider('viewportUnitsProvider')]
    public function test_viewport_units(string $input, string $expected): void
    {
        $sizeClass = SizeClass::parse($input);
        $this->assertInstanceOf(SizeClass::class, $sizeClass);
        $this->assertSame($expected, $sizeClass->toCss());
    }

    public static function viewportUnitsProvider(): array
    {
        return [
            ['size-screen', '.size-screen{width:100vw;height:100vw;}'],
            ['size-svw', '.size-svw{width:100svw;height:100svw;}'],
            ['size-lvw', '.size-lvw{width:100lvw;height:100lvw;}'],
            ['size-dvw', '.size-dvw{width:100dvw;height:100dvw;}'],
            ['size-[50vw]', '.size-\[50vw\]{width:50vw;height:50vw;}'],
            ['size-[75svw]', '.size-\[75svw\]{width:75svw;height:75svw;}'],
            ['size-[80lvw]', '.size-\[80lvw\]{width:80lvw;height:80lvw;}'],
            ['size-[90dvw]', '.size-\[90dvw\]{width:90dvw;height:90dvw;}'],
        ];
    }
}
