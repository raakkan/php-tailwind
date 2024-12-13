<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\FontWeightClass;

class FontWeightTest extends TestCase
{
    #[DataProvider('fontWeightClassProvider')]
    public function test_font_weight_class(string $input, string $expected): void
    {
        $fontWeightClass = FontWeightClass::parse($input);
        $this->assertInstanceOf(FontWeightClass::class, $fontWeightClass);
        $this->assertSame($expected, $fontWeightClass->toCss());
    }

    public static function fontWeightClassProvider(): array
    {
        return [
            // Predefined weights
            ['font-thin', '.font-thin{font-weight:100;}'],
            ['font-extralight', '.font-extralight{font-weight:200;}'],
            ['font-light', '.font-light{font-weight:300;}'],
            ['font-normal', '.font-normal{font-weight:400;}'],
            ['font-medium', '.font-medium{font-weight:500;}'],
            ['font-semibold', '.font-semibold{font-weight:600;}'],
            ['font-bold', '.font-bold{font-weight:700;}'],
            ['font-extrabold', '.font-extrabold{font-weight:800;}'],
            ['font-black', '.font-black{font-weight:900;}'],

            // Arbitrary values
            ['font-[100]', '.font-\[100\]{font-weight:100;}'],
            ['font-[400]', '.font-\[400\]{font-weight:400;}'],
            ['font-[900]', '.font-\[900\]{font-weight:900;}'],
        ];
    }

    public function test_invalid_font_weight_class(): void
    {
        $this->assertNull(FontWeightClass::parse('font-invalid'));
    }

    public function test_font_weight_class_with_invalid_value(): void
    {
        $fontWeightClass = FontWeightClass::parse('font-bolder');
        $this->assertNull($fontWeightClass);
    }

    #[DataProvider('invalidArbitraryFontWeightProvider')]
    public function test_invalid_arbitrary_font_weight(string $input): void
    {
        $fontWeightClass = FontWeightClass::parse($input);
        $this->assertInstanceOf(FontWeightClass::class, $fontWeightClass);
        $this->assertSame('', $fontWeightClass->toCss());
    }

    public static function invalidArbitraryFontWeightProvider(): array
    {
        return [
            ['font-[invalid]'],
            ['font-[abc]'],
        ];
    }

    #[DataProvider('validArbitraryFontWeightProvider')]
    public function test_valid_arbitrary_font_weight(string $input, string $expected): void
    {
        $fontWeightClass = FontWeightClass::parse($input);
        $this->assertInstanceOf(FontWeightClass::class, $fontWeightClass);
        $this->assertSame($expected, $fontWeightClass->toCss());
    }

    public static function validArbitraryFontWeightProvider(): array
    {
        return [
            ['font-[100]', '.font-\[100\]{font-weight:100;}'],
            ['font-[350]', '.font-\[350\]{font-weight:350;}'],
            ['font-[550]', '.font-\[550\]{font-weight:550;}'],
            ['font-[725]', '.font-\[725\]{font-weight:725;}'],
            ['font-[900]', '.font-\[900\]{font-weight:900;}'],
        ];
    }

    public function test_default_to_normal_weight(): void
    {
        $fontWeightClass = FontWeightClass::parse('font-unknown');
        $this->assertNull($fontWeightClass);
    }

    #[DataProvider('edgeCaseArbitraryFontWeightProvider')]
    public function test_edge_case_arbitrary_font_weight(string $input, string $expected): void
    {
        $fontWeightClass = FontWeightClass::parse($input);
        $this->assertInstanceOf(FontWeightClass::class, $fontWeightClass);
        $this->assertSame($expected, $fontWeightClass->toCss());
    }

    public static function edgeCaseArbitraryFontWeightProvider(): array
    {
        return [
            ['font-[100.5]', '.font-\[100\.5\]{font-weight:100.5;}'],
            ['font-[899.9]', '.font-\[899\.9\]{font-weight:899.9;}'],
        ];
    }

    #[DataProvider('specialCharactersFontWeightProvider')]
    public function test_special_characters_font_weight(string $input, string $expected): void
    {
        $fontWeightClass = FontWeightClass::parse($input);
        $this->assertInstanceOf(FontWeightClass::class, $fontWeightClass);
        $this->assertSame($expected, $fontWeightClass->toCss());
    }

    public static function specialCharactersFontWeightProvider(): array
    {
        return [
            ['font-[500!important]', '.font-\[500\!important\]{font-weight:500!important;}'],
            ['font-[calc(400+100)]', '.font-\[calc\(400\+100\)\]{font-weight:calc(400+100);}'],
        ];
    }
}
