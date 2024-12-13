<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\ListStyleTypeClass;

class ListStyleTypeTest extends TestCase
{
    #[DataProvider('listStyleTypeClassProvider')]
    public function test_list_style_type_class(string $input, string $expected): void
    {
        $listStyleTypeClass = ListStyleTypeClass::parse($input);
        $this->assertInstanceOf(ListStyleTypeClass::class, $listStyleTypeClass);
        $this->assertSame($expected, $listStyleTypeClass->toCss());
    }

    public static function listStyleTypeClassProvider(): array
    {
        return [
            // Predefined types
            ['list-none', '.list-none{list-style-type:none;}'],
            ['list-disc', '.list-disc{list-style-type:disc;}'],
            ['list-decimal', '.list-decimal{list-style-type:decimal;}'],

            // Arbitrary values
            ['list-[square]', '.list-\[square\]{list-style-type:square;}'],
            ['list-[upper-roman]', '.list-\[upper-roman\]{list-style-type:upper-roman;}'],
            ['list-[lower-alpha]', '.list-\[lower-alpha\]{list-style-type:lower-alpha;}'],
        ];
    }

    public function test_invalid_list_style_type_class(): void
    {
        $this->assertNull(ListStyleTypeClass::parse('list-invalid'));
    }

    public function test_list_style_type_class_with_invalid_value(): void
    {
        $listStyleTypeClass = ListStyleTypeClass::parse('list-circle');
        $this->assertNull($listStyleTypeClass);
    }

    #[DataProvider('invalidArbitraryListStyleTypeProvider')]
    public function test_invalid_arbitrary_list_style_type(string $input): void
    {
        $listStyleTypeClass = ListStyleTypeClass::parse($input);
        $this->assertInstanceOf(ListStyleTypeClass::class, $listStyleTypeClass);
        $this->assertSame('', $listStyleTypeClass->toCss());
    }

    public static function invalidArbitraryListStyleTypeProvider(): array
    {
        return [
            ['list-[123]'],
            ['list-[!invalid]'],
        ];
    }

    #[DataProvider('validArbitraryListStyleTypeProvider')]
    public function test_valid_arbitrary_list_style_type(string $input, string $expected): void
    {
        $listStyleTypeClass = ListStyleTypeClass::parse($input);
        $this->assertInstanceOf(ListStyleTypeClass::class, $listStyleTypeClass);
        $this->assertSame($expected, $listStyleTypeClass->toCss());
    }

    public static function validArbitraryListStyleTypeProvider(): array
    {
        return [
            ['list-[circle]', '.list-\[circle\]{list-style-type:circle;}'],
            ['list-[lower-roman]', '.list-\[lower-roman\]{list-style-type:lower-roman;}'],
            ['list-[upper-alpha]', '.list-\[upper-alpha\]{list-style-type:upper-alpha;}'],
            ['list-[georgian]', '.list-\[georgian\]{list-style-type:georgian;}'],
            ['list-[kannada]', '.list-\[kannada\]{list-style-type:kannada;}'],
        ];
    }

    public function test_default_to_none_type(): void
    {
        $listStyleTypeClass = ListStyleTypeClass::parse('list-unknown');
        $this->assertNull($listStyleTypeClass);
    }

    #[DataProvider('specialCharactersListStyleTypeProvider')]
    public function test_special_characters_list_style_type(string $input, string $expected): void
    {
        $listStyleTypeClass = ListStyleTypeClass::parse($input);
        $this->assertInstanceOf(ListStyleTypeClass::class, $listStyleTypeClass);
        $this->assertSame($expected, $listStyleTypeClass->toCss());
    }

    public static function specialCharactersListStyleTypeProvider(): array
    {
        return [
            ['list-[custom-image]', '.list-\[custom-image\]{list-style-type:custom-image;}'],
            ['list-[emoji]', '.list-\[emoji\]{list-style-type:emoji;}'],
        ];
    }

    #[DataProvider('caseInsensitiveProvider')]
    public function test_case_insensitive_list_style_type(string $input, string $expected): void
    {
        $listStyleTypeClass = ListStyleTypeClass::parse($input);
        $this->assertInstanceOf(ListStyleTypeClass::class, $listStyleTypeClass);
        $this->assertSame($expected, $listStyleTypeClass->toCss());
    }

    public static function caseInsensitiveProvider(): array
    {
        return [
            // ['list-NONE', '.list-NONE{list-style-type:none;}'],
            // ['list-Disc', '.list-Disc{list-style-type:disc;}'],
            // ['list-DECIMAL', '.list-DECIMAL{list-style-type:decimal;}'],
            ['list-[UPPER-ROMAN]', '.list-\[UPPER-ROMAN\]{list-style-type:UPPER-ROMAN;}'],
        ];
    }

    public function test_non_list_style_type_class(): void
    {
        $this->assertNull(ListStyleTypeClass::parse('font-bold'));
        $this->assertNull(ListStyleTypeClass::parse('text-lg'));
        $this->assertNull(ListStyleTypeClass::parse('bg-red-500'));
    }
}
