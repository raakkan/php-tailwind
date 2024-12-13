<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\TextDecorationThicknessClass;

class TextDecorationThicknessTest extends TestCase
{
    #[DataProvider('standardThicknessProvider')]
    public function test_standard_thickness_classes(string $input, string $expected): void
    {
        $thicknessClass = TextDecorationThicknessClass::parse($input);
        $this->assertInstanceOf(TextDecorationThicknessClass::class, $thicknessClass);
        $this->assertSame($expected, $thicknessClass->toCss());
    }

    public static function standardThicknessProvider(): array
    {
        return [
            ['decoration-auto', '.decoration-auto{text-decoration-thickness:auto;}'],
            ['decoration-from-font', '.decoration-from-font{text-decoration-thickness:from-font;}'],
            ['decoration-0', '.decoration-0{text-decoration-thickness:0px;}'],
            ['decoration-1', '.decoration-1{text-decoration-thickness:1px;}'],
            ['decoration-2', '.decoration-2{text-decoration-thickness:2px;}'],
            ['decoration-4', '.decoration-4{text-decoration-thickness:4px;}'],
            ['decoration-8', '.decoration-8{text-decoration-thickness:8px;}'],
        ];
    }

    #[DataProvider('arbitraryThicknessProvider')]
    public function test_arbitrary_thickness_classes(string $input, string $expected): void
    {
        $thicknessClass = TextDecorationThicknessClass::parse($input);
        $this->assertInstanceOf(TextDecorationThicknessClass::class, $thicknessClass);
        $this->assertSame($expected, $thicknessClass->toCss());
    }

    public static function arbitraryThicknessProvider(): array
    {
        return [
            ['decoration-[3px]', '.decoration-\[3px\]{text-decoration-thickness:3px;}'],
            ['decoration-[0.5em]', '.decoration-\[0\.5em\]{text-decoration-thickness:0.5em;}'],
            ['decoration-[3%]', '.decoration-\[3\%\]{text-decoration-thickness:3%;}'],
            // ['decoration-[calc(1em+2px)]', '.decoration-\[calc\(1em\+2px\)\]{text-decoration-thickness:calc(1em+2px);}'],
        ];
    }

    #[DataProvider('invalidThicknessProvider')]
    public function test_invalid_thickness_classes(string $input): void
    {
        $thicknessClass = TextDecorationThicknessClass::parse($input);
        $this->assertNull($thicknessClass);
    }

    public static function invalidThicknessProvider(): array
    {
        return [
            ['decoration-invalid'],
            ['decoration-5'],
            ['decoration-thin'],
            ['decoration-thick'],
            // ['decoration-[invalid]'],
            ['decoration-[3px'],
            ['decoration-3px]'],
        ];
    }

    #[DataProvider('edgeCaseThicknessProvider')]
    public function test_edge_case_thickness_classes(string $input, string $expected): void
    {
        $thicknessClass = TextDecorationThicknessClass::parse($input);
        $this->assertInstanceOf(TextDecorationThicknessClass::class, $thicknessClass);
        $this->assertSame($expected, $thicknessClass->toCss());
    }

    public static function edgeCaseThicknessProvider(): array
    {
        return [
            ['decoration-[0]', '.decoration-\[0\]{text-decoration-thickness:0;}'],
            ['decoration-[0px]', '.decoration-\[0px\]{text-decoration-thickness:0px;}'],
            ['decoration-[0.001em]', '.decoration-\[0\.001em\]{text-decoration-thickness:0.001em;}'],
            ['decoration-[100%]', '.decoration-\[100\%\]{text-decoration-thickness:100%;}'],
        ];
    }

    // public function testInvalidArbitraryValueReturnsEmptyString(): void
    // {
    //     $thicknessClass = TextDecorationThicknessClass::parse('decoration-[invalid]');
    //     $this->assertInstanceOf(TextDecorationThicknessClass::class, $thicknessClass);
    //     $this->assertSame('', $thicknessClass->toCss());
    // }

    // #[DataProvider('specialCharactersProvider')]
    // public function testSpecialCharactersInArbitraryValues(string $input, string $expected): void
    // {
    //     $thicknessClass = TextDecorationThicknessClass::parse($input);
    //     $this->assertInstanceOf(TextDecorationThicknessClass::class, $thicknessClass);
    //     $this->assertSame($expected, $thicknessClass->toCss());
    // }

    // public static function specialCharactersProvider(): array
    // {
    //     return [
    //         ['decoration-[3px!important]', '.decoration-\[3px\!important\]{text-decoration-thickness:3px!important;}'],
    //         ['decoration-[calc(1em+2px)]', '.decoration-\[calc\(1em\+2px\)\]{text-decoration-thickness:calc(1em+2px);}'],
    //         ['decoration-[clamp(1px,2em,3rem)]', '.decoration-\[clamp\(1px\,2em\,3rem\)\]{text-decoration-thickness:clamp(1px,2em,3rem);}'],
    //     ];
    // }

    public function test_non_decoration_class_returns_null(): void
    {
        $this->assertNull(TextDecorationThicknessClass::parse('font-bold'));
    }
}
