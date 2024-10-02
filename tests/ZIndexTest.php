<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Layout\ZIndexClass;
use PHPUnit\Framework\Attributes\DataProvider;

class ZIndexTest extends TestCase
{
    #[DataProvider('zIndexClassProvider')]
    public function testZIndexClass(string $input, string $expected): void
    {
        $zIndexClass = ZIndexClass::parse($input);
        $this->assertInstanceOf(ZIndexClass::class, $zIndexClass);
        $this->assertSame($expected, $zIndexClass->toCss());
    }

    public static function zIndexClassProvider(): array
    {
        return [
            // Standard values
            ['z-0', '.z-0{z-index:0;}'],
            ['z-10', '.z-10{z-index:10;}'],
            ['z-20', '.z-20{z-index:20;}'],
            ['z-30', '.z-30{z-index:30;}'],
            ['z-40', '.z-40{z-index:40;}'],
            ['z-50', '.z-50{z-index:50;}'],
            ['z-auto', '.z-auto{z-index:auto;}'],

            // Negative values
            ['-z-10', '.-z-10{z-index:-10;}'],
            ['-z-20', '.-z-20{z-index:-20;}'],
            ['-z-30', '.-z-30{z-index:-30;}'],
            ['-z-40', '.-z-40{z-index:-40;}'],
            ['-z-50', '.-z-50{z-index:-50;}'],

            // Arbitrary values
            ['z-[100]', '.z-\[100\]{z-index:100;}'],
            ['z-[42]', '.z-\[42\]{z-index:42;}'],
            ['z-[1000]', '.z-\[1000\]{z-index:1000;}'],
            ['z-[-5]', '.z-\[-5\]{z-index:-5;}'],

            // Arbitrary values with CSS variables
            ['z-[var(--my-z-index)]', '.z-\[var\(--my-z-index\)\]{z-index:var(--my-z-index);}'],

            // Negative arbitrary values
            ['-z-[100]', '.-z-\[100\]{z-index:-100;}'],
            ['-z-[42]', '.-z-\[42\]{z-index:-42;}'],

            // Invalid standard values (should return empty string)
            ['z-60', ''],
            ['z-15', ''],

            // Invalid arbitrary values (should return empty string)
            ['z-[abc]', ''],
            ['z-[10px]', ''],
        ];
    }

    public function testInvalidZIndexClass(): void
    {
        $this->assertNull(ZIndexClass::parse('invalid-class'));
    }

    public function testZIndexClassWithInvalidValue(): void
    {
        $zIndexClass = ZIndexClass::parse('z-invalid');
        $this->assertInstanceOf(ZIndexClass::class, $zIndexClass);
        $this->assertSame('', $zIndexClass->toCss());
    }
}