<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\ListStyleTypeClass;
use PHPUnit\Framework\Attributes\DataProvider;

class ListStyleTypeTest extends TestCase
{
    #[DataProvider('listStyleTypeClassProvider')]
    public function testListStyleTypeClass(string $input, string $expected): void
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

    public function testInvalidListStyleTypeClass(): void
    {
        $this->assertNull(ListStyleTypeClass::parse('list-invalid'));
    }

    public function testListStyleTypeClassWithInvalidValue(): void
    {
        $listStyleTypeClass = ListStyleTypeClass::parse('list-circle');
        $this->assertNull($listStyleTypeClass);
    }

    #[DataProvider('invalidArbitraryListStyleTypeProvider')]
    public function testInvalidArbitraryListStyleType(string $input): void
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
    public function testValidArbitraryListStyleType(string $input, string $expected): void
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

    public function testDefaultToNoneType(): void
    {
        $listStyleTypeClass = ListStyleTypeClass::parse('list-unknown');
        $this->assertNull($listStyleTypeClass);
    }

    #[DataProvider('specialCharactersListStyleTypeProvider')]
    public function testSpecialCharactersListStyleType(string $input, string $expected): void
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
    public function testCaseInsensitiveListStyleType(string $input, string $expected): void
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

    public function testNonListStyleTypeClass(): void
    {
        $this->assertNull(ListStyleTypeClass::parse('font-bold'));
        $this->assertNull(ListStyleTypeClass::parse('text-lg'));
        $this->assertNull(ListStyleTypeClass::parse('bg-red-500'));
    }
}