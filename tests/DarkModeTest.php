<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\DarkModeClass;

class DarkModeTest extends TestCase
{
    #[DataProvider('darkModeClassProvider')]
    public function test_dark_mode_class(string $input, string $expected): void
    {
        $darkModeClass = DarkModeClass::parse($input);
        $this->assertInstanceOf(DarkModeClass::class, $darkModeClass);
        $this->assertSame($expected, $darkModeClass->toCss());
    }

    public static function darkModeClassProvider(): array
    {
        return [
            ['dark:text-white', '.dark\:text-white:where(.dark, .dark *){--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity));}'],
            ['dark:bg-black', '.dark\:bg-black:where(.dark, .dark *){--tw-bg-opacity:1;background-color:rgb(0 0 0 / var(--tw-bg-opacity));}'],
            ['dark:border-gray-700', '.dark\:border-gray-700:where(.dark, .dark *){--tw-border-opacity:1;border-color:rgb(55 65 81 / var(--tw-border-opacity));}'],
            ['dark:hover:text-gray-300', '.dark\:hover\:text-gray-300:hover:where(.dark, .dark *){--tw-text-opacity:1;color:rgb(209 213 219 / var(--tw-text-opacity));}'],
            ['dark:focus:border-blue-500', '.dark\:focus\:border-blue-500:focus:where(.dark, .dark *){--tw-border-opacity:1;border-color:rgb(59 130 246 / var(--tw-border-opacity));}'],
            ['dark:text-[#ff00ff]', '.dark\:text-\[\#ff00ff\]:where(.dark, .dark *){color:#ff00ff;}'],
            ['dark:bg-[rgb(255,0,255)]', '.dark\:bg-\[rgb\(255\2c 0\2c 255\)\]:where(.dark, .dark *){background-color:rgb(255,0,255);}'],
            ['dark:text-blue-500/75', '.dark\:text-blue-500\/75:where(.dark, .dark *){color:rgb(59 130 246 / 0.75);}'],
            ['dark:-mt-4', '.dark\:-mt-4:where(.dark, .dark *){margin-top:-1rem;}'],
        ];
    }

    public function test_invalid_dark_mode_class(): void
    {
        $this->assertNull(DarkModeClass::parse('light:text-white'));
    }

    public function test_dark_mode_class_with_invalid_value(): void
    {
        $darkModeClass = DarkModeClass::parse('dark:invalid-class');
        $this->assertInstanceOf(DarkModeClass::class, $darkModeClass);
        $this->assertSame('', $darkModeClass->toCss());
    }

    // public function testMultipleDarkModeClasses(): void
    // {
    //     $input = 'dark:text-white dark:bg-black dark:p-4';
    //     $expected = '.dark\:text-white:where(.dark, .dark *){--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}'
    //               . '.dark\:bg-black:where(.dark, .dark *){--tw-bg-opacity:1;background-color:rgb(0 0 0 / var(--tw-bg-opacity))}'
    //               . '.dark\:p-4:where(.dark, .dark *){padding:1rem}';

    //     $darkModeClass = DarkModeClass::parse($input);
    //     $this->assertInstanceOf(DarkModeClass::class, $darkModeClass);
    //     $this->assertSame($expected, $darkModeClass->toCss());
    // }

    // public function testDarkModeWithNonDarkClasses(): void
    // {
    //     $input = 'text-black dark:text-white bg-white dark:bg-black';
    //     $expected = '.dark\:text-white:where(.dark, .dark *){--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}'
    //               . '.dark\:bg-black:where(.dark, .dark *){--tw-bg-opacity:1;background-color:rgb(0 0 0 / var(--tw-bg-opacity))}';

    //     $darkModeClass = DarkModeClass::parse($input);
    //     $this->assertInstanceOf(DarkModeClass::class, $darkModeClass);
    //     $this->assertSame($expected, $darkModeClass->toCss());
    // }
}
