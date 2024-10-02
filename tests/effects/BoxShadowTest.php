<?php

namespace Raakkan\PhpTailwind\Tests\Effects;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Effects\BoxShadowClass;
use PHPUnit\Framework\Attributes\DataProvider;

class BoxShadowTest extends TestCase
{
    #[DataProvider('standardShadowProvider')]
    public function testStandardShadows(string $input, string $expected): void
    {
        $boxShadowClass = BoxShadowClass::parse($input);
        $this->assertInstanceOf(BoxShadowClass::class, $boxShadowClass);
        $this->assertSame($expected, $boxShadowClass->toCss());
    }

    public static function standardShadowProvider(): array
    {
        return [
            ['shadow-sm', ".shadow-sm{--tw-shadow:0 1px 2px 0 rgb(0 0 0 / 0.05);--tw-shadow-colored:0 1px 2px 0 var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
            ['shadow', ".shadow{--tw-shadow:0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
            ['shadow-md', ".shadow-md{--tw-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
            ['shadow-lg', ".shadow-lg{--tw-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
            ['shadow-xl', ".shadow-xl{--tw-shadow:0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
            ['shadow-2xl', ".shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
            ['shadow-inner', ".shadow-inner{--tw-shadow:inset 0 2px 4px 0 rgb(0 0 0 / 0.05);--tw-shadow-colored:inset 0 2px 4px 0 var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
            ['shadow-none', ".shadow-none{--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
        ];
    }

    // TODO: box shadow arbitrary pending
    // #[DataProvider('arbitraryValueProvider')]
    // public function testArbitraryValues(string $input, string $expected): void
    // {
    //     $boxShadowClass = BoxShadowClass::parse($input);
    //     $this->assertInstanceOf(BoxShadowClass::class, $boxShadowClass);
    //     $this->assertSame($expected, $boxShadowClass->toCss());
    // }

    // public static function arbitraryValueProvider(): array
    // {
    //     return [
    //         ['shadow-[0_35px_60px_-15px_rgba(0,0,0,0.3)]', ".shadow-\\[0_35px_60px_-15px_rgba\\(0\\2c 0\\2c 0\\2c 0\\.3\\)\\]{--tw-shadow:0 35px 60px -15px rgba(0,0,0,0.3);--tw-shadow-colored:0 35px 60px -15px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
    //         ['shadow-[0_2px_10px_#00000080]', ".shadow-\\[0_2px_10px_\\#00000080\\]{--tw-shadow:0 2px 10px #00000080;--tw-shadow-colored:0 2px 10px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
    //         ['shadow-[inset_0_2px_4px_0_rgba(0,0,0,0.05)]', ".shadow-\\[inset_0_2px_4px_0_rgba\\(0\\2c 0\\2c 0\\2c 0\\.05\\)\\]{--tw-shadow:inset 0 2px 4px 0 rgba(0,0,0,0.05);--tw-shadow-colored:inset 0 2px 4px 0 var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}"],
    //     ];
    // }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $boxShadowClass = BoxShadowClass::parse($input);
        $this->assertNull($boxShadowClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['shadow-invalid'],
            ['shadow-3xl'],
            // ['shadow-[invalid]'],
            // ['shadow-[0 0 10px]'], // Missing unit
            ['not-a-shadow-class'],
        ];
    }

    // public function testDefaultShadow(): void
    // {
    //     $boxShadowClass = BoxShadowClass::parse('shadow');
    //     $this->assertInstanceOf(BoxShadowClass::class, $boxShadowClass);
    //     $this->assertStringContainsString('shadow-DEFAULT', $boxShadowClass->toCss());
    // }

    // public function testArbitraryShadowWithComplexValue(): void
    // {
    //     $input = 'shadow-[0_10px_15px_-3px_rgba(0,0,0,0.1),0_4px_6px_-4px_rgba(0,0,0,0.1)]';
    //     $expected = ".shadow-\\[0_10px_15px_-3px_rgba\\(0\\2c 0\\2c 0\\2c 0\\.1\\)\\2c 0_4px_6px_-4px_rgba\\(0\\2c 0\\2c 0\\2c 0\\.1\\)\\]{--tw-shadow:0 10px 15px -3px rgba(0,0,0,0.1),0 4px 6px -4px rgba(0,0,0,0.1);--tw-shadow-colored:0 10px 15px -3px var(--tw-shadow-color),0 4px 6px -4px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);}";
        
    //     $boxShadowClass = BoxShadowClass::parse($input);
    //     $this->assertInstanceOf(BoxShadowClass::class, $boxShadowClass);
    //     $this->assertSame($expected, $boxShadowClass->toCss());
    // }
}