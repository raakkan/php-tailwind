<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\FontSizeClass;

class FontSizeTest extends TestCase
{
    #[DataProvider('fontSizeClassProvider')]
    public function test_font_size_class(string $input, string $expected): void
    {
        $fontSizeClass = FontSizeClass::parse($input);
        $this->assertInstanceOf(FontSizeClass::class, $fontSizeClass);
        $this->assertSame($expected, $fontSizeClass->toCss());
    }

    public static function fontSizeClassProvider(): array
    {
        return [
            // Predefined sizes
            ['text-xs', '.text-xs{font-size:0.75rem;line-height:1rem;}'],
            ['text-sm', '.text-sm{font-size:0.875rem;line-height:1.25rem;}'],
            ['text-base', '.text-base{font-size:1rem;line-height:1.5rem;}'],
            ['text-lg', '.text-lg{font-size:1.125rem;line-height:1.75rem;}'],
            ['text-xl', '.text-xl{font-size:1.25rem;line-height:1.75rem;}'],
            ['text-2xl', '.text-2xl{font-size:1.5rem;line-height:2rem;}'],
            ['text-3xl', '.text-3xl{font-size:1.875rem;line-height:2.25rem;}'],
            ['text-4xl', '.text-4xl{font-size:2.25rem;line-height:2.5rem;}'],
            ['text-5xl', '.text-5xl{font-size:3rem;line-height:1;}'],
            ['text-6xl', '.text-6xl{font-size:3.75rem;line-height:1;}'],
            ['text-7xl', '.text-7xl{font-size:4.5rem;line-height:1;}'],
            ['text-8xl', '.text-8xl{font-size:6rem;line-height:1;}'],
            ['text-9xl', '.text-9xl{font-size:8rem;line-height:1;}'],

            // Arbitrary values
            ['text-[14px]', '.text-\[14px\]{font-size:14px;line-height:normal;}'],
            ['text-[1rem]', '.text-\[1rem\]{font-size:1rem;line-height:normal;}'],
            ['text-[0.875em]', '.text-\[0\.875em\]{font-size:0.875em;line-height:normal;}'],
            ['text-[2.5vw]', '.text-\[2\.5vw\]{font-size:2.5vw;line-height:normal;}'],
            ['text-[calc(1rem+2px)]', '.text-\[calc\(1rem\+2px\)\]{font-size:calc(1rem+2px);line-height:normal;}'],
        ];
    }

    public function test_invalid_font_size_class(): void
    {
        $this->assertNull(FontSizeClass::parse('text-invalid'));
    }

    public function test_font_size_class_with_invalid_value(): void
    {
        $fontSizeClass = FontSizeClass::parse('text-10xl');
        $this->assertNull($fontSizeClass);
    }

    #[DataProvider('invalidArbitraryFontSizeProvider')]
    public function test_invalid_arbitrary_font_size(string $input): void
    {
        $fontSizeClass = FontSizeClass::parse($input);
        $this->assertInstanceOf(FontSizeClass::class, $fontSizeClass);
        $this->assertSame('', $fontSizeClass->toCss());
    }

    public static function invalidArbitraryFontSizeProvider(): array
    {
        return [
            ['text-[invalid]'],
            ['text-[10]'],
            ['text-[rem]'],
            ['text-[calc()]'],
        ];
    }

    #[DataProvider('validArbitraryFontSizeProvider')]
    public function test_valid_arbitrary_font_size(string $input, string $expected): void
    {
        $fontSizeClass = FontSizeClass::parse($input);
        $this->assertInstanceOf(FontSizeClass::class, $fontSizeClass);
        $this->assertSame($expected, $fontSizeClass->toCss());
    }

    public static function validArbitraryFontSizeProvider(): array
    {
        return [
            ['text-[12px]', '.text-\[12px\]{font-size:12px;line-height:normal;}'],
            ['text-[0.5em]', '.text-\[0\.5em\]{font-size:0.5em;line-height:normal;}'],
            ['text-[1.25rem]', '.text-\[1\.25rem\]{font-size:1.25rem;line-height:normal;}'],
            ['text-[2vw]', '.text-\[2vw\]{font-size:2vw;line-height:normal;}'],
            ['text-[calc(1rem+5px)]', '.text-\[calc\(1rem\+5px\)\]{font-size:calc(1rem+5px);line-height:normal;}'],
            ['text-[clamp(12px,5vw,36px)]', '.text-\[clamp\(12px\2c 5vw\2c 36px\)\]{font-size:clamp(12px,5vw,36px);line-height:normal;}'],
        ];
    }

    public function test_default_to_base_size(): void
    {
        $fontSizeClass = FontSizeClass::parse('text-unknown');
        $this->assertNull($fontSizeClass);
    }

    #[DataProvider('negativeArbitraryFontSizeProvider')]
    public function test_negative_arbitrary_font_size(string $input, string $expected): void
    {
        $fontSizeClass = FontSizeClass::parse($input);
        $this->assertInstanceOf(FontSizeClass::class, $fontSizeClass);
        $this->assertSame($expected, $fontSizeClass->toCss());
    }

    public static function negativeArbitraryFontSizeProvider(): array
    {
        return [
            ['text-[-12px]', '.text-\[-12px\]{font-size:-12px;line-height:normal;}'],
            ['text-[-0.5em]', '.text-\[-0\.5em\]{font-size:-0.5em;line-height:normal;}'],
            ['text-[-1.25rem]', '.text-\[-1\.25rem\]{font-size:-1.25rem;line-height:normal;}'],
        ];
    }

    #[DataProvider('invalidArbitraryFunctionProvider')]
    public function test_invalid_arbitrary_function(string $input): void
    {
        $fontSizeClass = FontSizeClass::parse($input);
        $this->assertInstanceOf(FontSizeClass::class, $fontSizeClass);
        $this->assertSame('', $fontSizeClass->toCss());
    }

    public static function invalidArbitraryFunctionProvider(): array
    {
        return [
            ['text-[calc()]'],
        ];
    }
}
