<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\PseudoClass;
use PHPUnit\Framework\Attributes\DataProvider;

class PseudoClassTest extends TestCase
{
    #[DataProvider('pseudoClassProvider')]
    public function testPseudoClass(string $input, string $expected): void
    {
        $pseudoClass = PseudoClass::parse($input);
        $this->assertInstanceOf(PseudoClass::class, $pseudoClass);
        $this->assertSame($expected, $pseudoClass->toCss());
    }

    public static function pseudoClassProvider(): array
    {
        return [
            ['hover:bg-blue-500', ".hover\\:bg-blue-500:hover{--tw-bg-opacity: 1;background-color: rgb(59 130 246 / var(--tw-bg-opacity));}"],
            ['focus:text-red-700', ".focus\\:text-red-700:focus{--tw-text-opacity: 1;color: rgb(185 28 28 / var(--tw-text-opacity));}"],
            ['active:scale-95', ".active\\:scale-95:active{--tw-scale-x:.95;--tw-scale-y:.95;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"],
            ['hover:rounded-lg', ".hover\\:rounded-lg:hover{border-radius:0.5rem;}"],
            ['focus:border-2', ".focus\\:border-2:focus{border-width:2px;}"],
            ['active:opacity-75', ".active\\:opacity-75:active{opacity:0.75;}"],
        ];
    }

    // #[DataProvider('invalidPseudoClassProvider')]
    // public function testInvalidPseudoClass(string $input): void
    // {
    //     $this->assertNull(PseudoClass::parse($input));
    // }

    // public static function invalidPseudoClassProvider(): array
    // {
    //     return [
    //         ['invalid:bg-blue-500'],
    //         ['hover:invalid-class'],
    //         ['focus:'],
    //         ['active'],
    //         ['hover:focus:bg-red-500'], // Nested pseudo-classes are not supported in this implementation
    //     ];
    // }

    public function testPseudoClassGetters(): void
    {
        $pseudoClass = PseudoClass::parse('hover:bg-blue-500');
        $this->assertInstanceOf(PseudoClass::class, $pseudoClass);
        $this->assertSame('hover', $pseudoClass->getPseudoClass());
        $this->assertSame('bg-blue-500', $pseudoClass->getActualClass());
    }

    // #[DataProvider('multiplePseudoClassesProvider')]
    // public function testMultiplePseudoClasses(array $inputs, array $expected): void
    // {
    //     $css = '';
    //     foreach ($inputs as $input) {
    //         $pseudoClass = PseudoClass::parse($input);
    //         $this->assertInstanceOf(PseudoClass::class, $pseudoClass);
    //         $css .= $pseudoClass->toCss();
    //     }
    //     $this->assertSame(implode('', $expected), $css);
    // }

    // public static function multiplePseudoClassesProvider(): array
    // {
    //     return [
    //         [
    //             ['hover:bg-blue-500', 'focus:text-red-700', 'active:scale-95'],
    //             [
    //                 ".hover\\:bg-blue-500:hover{background-color:#3b82f6;}",
    //                 ".focus\\:text-red-700:focus{color:#b91c1c;}",
    //                 ".active\\:scale-95:active{--tw-scale-x:0.95;--tw-scale-y:0.95;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}"
    //             ]
    //         ],
    //     ];
    // }
}