<?php

namespace Raakkan\PhpTailwind\Tests\Transforms;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Transforms\TranslateClass;

class TranslateTest extends TestCase
{
    #[DataProvider('translateClassProvider')]
    public function testTranslateClass(string $input, string $expected): void
    {
        $translateClass = TranslateClass::parse($input);
        $this->assertInstanceOf(TranslateClass::class, $translateClass);
        $this->assertSame($expected, $translateClass->toCss());
    }

    public static function translateClassProvider(): array
    {
        return [
            // X-axis
            ['translate-x-0', '.translate-x-0{--tw-translate-x:0px;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['translate-x-1', '.translate-x-1{--tw-translate-x:0.25rem;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['translate-x-4', '.translate-x-4{--tw-translate-x:1rem;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['translate-x-1/2', '.translate-x-1/2{--tw-translate-x:50%;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['translate-x-full', '.translate-x-full{--tw-translate-x:100%;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],

            // Y-axis
            ['translate-y-0', '.translate-y-0{--tw-translate-y:0px;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['translate-y-2', '.translate-y-2{--tw-translate-y:0.5rem;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['translate-y-3/4', '.translate-y-3/4{--tw-translate-y:75%;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],

            // Negative values
            ['-translate-x-4', '.-translate-x-4{--tw-translate-x:-1rem;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-translate-y-1/2', '.-translate-y-1/2{--tw-translate-y:-50%;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],

            // Both axes
            ['translate-x-2', '.translate-x-2{--tw-translate-x:0.5rem;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['translate-y-3', '.translate-y-3{--tw-translate-y:0.75rem;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
        ];
    }

    #[DataProvider('arbitraryTranslateClassProvider')]
    public function testArbitraryTranslateClass(string $input, string $expected): void
    {
        $translateClass = TranslateClass::parse($input);
        $this->assertInstanceOf(TranslateClass::class, $translateClass);
        $this->assertSame($expected, $translateClass->toCss());
    }

    public static function arbitraryTranslateClassProvider(): array
    {
        return [
            ['translate-x-[10px]', '.translate-x-[10px]{--tw-translate-x:10px;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['translate-y-[2rem]', '.translate-y-[2rem]{--tw-translate-y:2rem;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['translate-x-[10%]', '.translate-x-[10%]{--tw-translate-x:10%;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['translate-y-[20vh]', '.translate-y-[20vh]{--tw-translate-y:20vh;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
            ['-translate-x-[5em]', '.-translate-x-[5em]{--tw-translate-x:-5em;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}'],
        ];
    }

    public function testInvalidTranslateClass(): void
    {
        $this->assertNull(TranslateClass::parse('invalid-class'));
    }

    #[DataProvider('invalidTranslateValueProvider')]
    public function testTranslateClassWithInvalidValue(string $input): void
    {
        $translateClass = TranslateClass::parse($input);
        $this->assertInstanceOf(TranslateClass::class, $translateClass);
        $this->assertSame('', $translateClass->toCss());
    }

    public static function invalidTranslateValueProvider(): array
    {
        return [
            ['translate-x-13'],
            ['translate-y-1/5'],
            ['translate-x-200'],
            ['translate-y-extra'],
        ];
    }

    #[DataProvider('invalidArbitraryTranslateClassProvider')]
    public function testInvalidArbitraryTranslateClass(string $input): void
    {
        $translateClass = TranslateClass::parse($input);
        $this->assertInstanceOf(TranslateClass::class, $translateClass);
        $this->assertSame('', $translateClass->toCss());
    }

    public static function invalidArbitraryTranslateClassProvider(): array
    {
        return [
            ['translate-x-[invalid]'],
            ['translate-y-[]'],
            // ['translate-x-[10]'],
            ['translate-y-[rem]'],
        ];
    }
}
