<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\ContentClass;

class ContentClassTest extends TestCase
{
    #[DataProvider('contentClassProvider')]
    public function test_content_class(string $input, string $expected): void
    {
        $contentClass = ContentClass::parse($input);
        $this->assertInstanceOf(ContentClass::class, $contentClass);
        $this->assertSame($expected, $contentClass->toCss());
    }

    public static function contentClassProvider(): array
    {
        return [
            // Standard values
            ['before:content-none', ".content-none {--tw-content: none;content: var(--tw-content);}.before\:content-none::before {--tw-content: none;content: var(--tw-content);}"],
            ['after:content-none', ".content-none {--tw-content: none;content: var(--tw-content);}.after\:content-none::after {--tw-content: none;content: var(--tw-content);}"],
            ['before:content-empty', ".content-empty {--tw-content: \"\";content: var(--tw-content);}.before\:content-empty::before {--tw-content: \"\";content: var(--tw-content);}"],
            ['after:content-empty', ".content-empty {--tw-content: \"\";content: var(--tw-content);}.after\:content-empty::after {--tw-content: \"\";content: var(--tw-content);}"],

            // Arbitrary values
            ['before:content-[Hello]', ".content-\[Hello\] {--tw-content: Hello;content: var(--tw-content);}.before\:content-\[Hello\]::before {--tw-content: Hello;content: var(--tw-content);}"],
            ['after:content-[World]', ".content-\[World\] {--tw-content: World;content: var(--tw-content);}.after\:content-\[World\]::after {--tw-content: World;content: var(--tw-content);}"],

            // Unicode characters
            // ["after:content-['_↗']", ".content-\[\'_\2197\'\] {--tw-content: '_↗';content: var(--tw-content);}.after\:content-\[\'_\2197\'\]::after {--tw-content: '_↗';content: var(--tw-content);}"],
            // ["before:content-['→']", ".content-\[\'\\2192\'\] {--tw-content: '→';content: var(--tw-content);}.before\:content-\[\'\\2192\'\]::before {--tw-content: '→';content: var(--tw-content);}"],

            // Complex arbitrary values
            // ['before:content-[attr(data-content)]', ".content-\[attr\(data-content\)\] {--tw-content: attr(data-content);content: var(--tw-content);}.before\:content-\[attr\(data-content\)\]::before {--tw-content: attr(data-content);content: var(--tw-content);}"],
            ['after:content-[url(/img/icon.svg)]', ".content-\[url\(\/img\/icon\.svg\)\] {--tw-content: url(/img/icon.svg);content: var(--tw-content);}.after\:content-\[url\(\/img\/icon\.svg\)\]::after {--tw-content: url(/img/icon.svg);content: var(--tw-content);}"],
            // ['before:content-["Hello_World"]', ".content-\[\"Hello_World\"\] {--tw-content: \"Hello_World\";content: var(--tw-content);}.before\:content-\[\"Hello_World\"\]::before {--tw-content: \"Hello_World\";content: var(--tw-content);}"],
        ];
    }

    public function test_invalid_content_class(): void
    {
        $this->assertNull(ContentClass::parse('content-none'));
        $this->assertNull(ContentClass::parse('before:font-bold'));
        $this->assertNull(ContentClass::parse('after:padding-4'));
    }

    // #[DataProvider('invalidContentValueProvider')]
    // public function testContentClassWithInvalidValue(string $input): void
    // {
    //     $contentClass = ContentClass::parse($input);
    //     $this->assertInstanceOf(ContentClass::class, $contentClass);
    //     $this->assertSame('', $contentClass->toCss());
    // }

    // public static function invalidContentValueProvider(): array
    // {
    //     return [
    //         ['before:content-invalid'],
    //         ['after:content-something'],
    //     ];
    // }

    // #[DataProvider('specialCharactersContentProvider')]
    // public function testSpecialCharactersContent(string $input, string $expected): void
    // {
    //     $contentClass = ContentClass::parse($input);
    //     $this->assertInstanceOf(ContentClass::class, $contentClass);
    //     $this->assertSame($expected, $contentClass->toCss());
    // }

    // public static function specialCharactersContentProvider(): array
    // {
    //     return [
    //         ['before:content-[!important]', ".content-\[\!important\] {--tw-content: !important;content: var(--tw-content);}.before\:content-\[\!important\]::before {--tw-content: !important;content: var(--tw-content);}"],
    //         ['after:content-[calc(100%+1rem)]', ".content-\[calc\(100\%\+1rem\)\] {--tw-content: calc(100%+1rem);content: var(--tw-content);}.after\:content-\[calc\(100\%\+1rem\)\]::after {--tw-content: calc(100%+1rem);content: var(--tw-content);}"],
    //         ['before:content-["@media(min-width:768px)"]', ".content-\[\"@media\(min-width\:768px\)\"\] {--tw-content: \"@media(min-width:768px)\";content: var(--tw-content);}.before\:content-\[\"@media\(min-width\:768px\)\"\]::before {--tw-content: \"@media(min-width:768px)\";content: var(--tw-content);}"],
    //     ];
    // }

    public function test_pseudo_element_consistency(): void
    {
        $beforeClass = ContentClass::parse('before:content-[Test]');
        $afterClass = ContentClass::parse('after:content-[Test]');

        $this->assertStringContainsString('::before', $beforeClass->toCss());
        $this->assertStringContainsString('::after', $afterClass->toCss());
    }

    // #[DataProvider('escapingTestProvider')]
    // public function testProperEscaping(string $input, string $expectedEscaped): void
    // {
    //     $contentClass = ContentClass::parse($input);
    //     $this->assertInstanceOf(ContentClass::class, $contentClass);
    //     $this->assertStringContainsString($expectedEscaped, $contentClass->toCss());
    // }

    // public static function escapingTestProvider(): array
    // {
    //     return [
    //         ['before:content-[.special::before]', '\[\.special\:\:before\]'],
    //         ['after:content-[#id > .class]', '\[\#id > \.class\]'],
    //     ];
    // }

    // public function testMultipleUnicodeCharacters(): void
    // {
    //     $contentClass = ContentClass::parse("before:content-['↑↓←→']");
    //     $expected = ".content-\[\'\\2191\\2193\\2190\\2192\'\] {--tw-content: '↑↓←→';content: var(--tw-content);}.before\:content-\[\'\\2191\\2193\\2190\\2192\'\]::before {--tw-content: '↑↓←→';content: var(--tw-content);}";
    //     $this->assertSame($expected, $contentClass->toCss());
    // }

    // public function testMixedContentWithUnicode(): void
    // {
    //     $contentClass = ContentClass::parse("after:content-['Next page →']");
    //     $expected = ".content-\[\'Next page \\2192\'\] {--tw-content: 'Next page →';content: var(--tw-content);}.after\:content-\[\'Next page \\2192\'\]::after {--tw-content: 'Next page →';content: var(--tw-content);}";
    //     $this->assertSame($expected, $contentClass->toCss());
    // }

    // public function testContentWithEmoji(): void
    // {
    //     $contentClass = ContentClass::parse("before:content-['🚀']");
    //     $expected = ".content-\[\'\\1F680\'\] {--tw-content: '🚀';content: var(--tw-content);}.before\:content-\[\'\\1F680\'\]::before {--tw-content: '🚀';content: var(--tw-content);}";
    //     $this->assertSame($expected, $contentClass->toCss());
    // }
}
