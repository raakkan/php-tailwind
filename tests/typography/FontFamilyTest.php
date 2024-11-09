<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\FontFamilyClass;

class FontFamilyTest extends TestCase
{
    #[DataProvider('fontFamilyClassProvider')]
    public function testFontFamilyClass(string $input, string $expected): void
    {
        $fontFamilyClass = FontFamilyClass::parse($input);
        $this->assertInstanceOf(FontFamilyClass::class, $fontFamilyClass);
        $this->assertSame($expected, $fontFamilyClass->toCss());
    }

    public static function fontFamilyClassProvider(): array
    {
        return [
            // Predefined values
            ['font-sans', '.font-sans{font-family:ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";}'],
            ['font-serif', '.font-serif{font-family:ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;}'],
            ['font-mono', '.font-mono{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;}'],

            // Arbitrary values (as per Tailwind documentation)
            ['font-[ui-sans-serif]', '.font-\[ui-sans-serif\]{font-family:ui-sans-serif;}'],
            ['font-[\'Open_Sans\']', '.font-\[\\\'Open_Sans\\\'\]{font-family:\'Open_Sans\';}'],
            ['font-["Helvetica_Neue"]', '.font-\[\"Helvetica_Neue\"\]{font-family:"Helvetica_Neue";}'],
            ['font-[Inter]', '.font-\[Inter\]{font-family:Inter;}'],
            ['font-[system-ui]', '.font-\[system-ui\]{font-family:system-ui;}'],
            ['font-[ui-monospace]', '.font-\[ui-monospace\]{font-family:ui-monospace;}'],

            // Multiple fonts in arbitrary value
            ['font-[ui-sans-serif,system-ui,sans-serif]', '.font-\[ui-sans-serif\2c system-ui\2c sans-serif\]{font-family:ui-sans-serif,system-ui,sans-serif;}'],
        ];
    }

    public function testInvalidFontFamilyClass(): void
    {
        $this->assertNull(FontFamilyClass::parse('invalid-class'));
    }

    #[DataProvider('invalidFontFamilyProvider')]
    public function testInvalidFontFamily(string $input): void
    {
        $fontFamilyClass = FontFamilyClass::parse($input);
        $this->assertInstanceOf(FontFamilyClass::class, $fontFamilyClass);
        $this->assertSame('', $fontFamilyClass->toCss());
    }

    public static function invalidFontFamilyProvider(): array
    {
        return [
            ['font-invalid'],
            ['font-123'],
            ['font-sans-serif'], // This is not a valid Tailwind class
        ];
    }

    #[DataProvider('escapedArbitraryValueProvider')]
    public function testEscapedArbitraryValue(string $input, string $expected): void
    {
        $fontFamilyClass = FontFamilyClass::parse($input);
        $this->assertInstanceOf(FontFamilyClass::class, $fontFamilyClass);
        $this->assertSame($expected, $fontFamilyClass->toCss());
    }

    public static function escapedArbitraryValueProvider(): array
    {
        return [
            ['font-[Open_Sans]', '.font-\[Open_Sans\]{font-family:Open_Sans;}'],
            ['font-[Noto_Sans_JP]', '.font-\[Noto_Sans_JP\]{font-family:Noto_Sans_JP;}'],
        ];
    }
}
