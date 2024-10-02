<?php

namespace Raakkan\PhpTailwind\Tests\Tables;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Tables\BorderSpacingClass;
use PHPUnit\Framework\Attributes\DataProvider;

class BorderSpacingTest extends TestCase
{
    #[DataProvider('borderSpacingClassProvider')]
    public function testBorderSpacingClass(string $input, string $expected): void
    {
        $borderSpacingClass = BorderSpacingClass::parse($input);
        $this->assertInstanceOf(BorderSpacingClass::class, $borderSpacingClass);
        $this->assertSame($expected, $borderSpacingClass->toCss());
    }

    public static function borderSpacingClassProvider(): array
    {
        return [
            // Standard values
            ['border-spacing-0', ".border-spacing-0{--tw-border-spacing-x:0px;--tw-border-spacing-y:0px;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-px', ".border-spacing-px{--tw-border-spacing-x:1px;--tw-border-spacing-y:1px;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-1', ".border-spacing-1{--tw-border-spacing-x:0.25rem;--tw-border-spacing-y:0.25rem;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-2', ".border-spacing-2{--tw-border-spacing-x:0.5rem;--tw-border-spacing-y:0.5rem;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-4', ".border-spacing-4{--tw-border-spacing-x:1rem;--tw-border-spacing-y:1rem;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-8', ".border-spacing-8{--tw-border-spacing-x:2rem;--tw-border-spacing-y:2rem;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            
            // Fractional values
            ['border-spacing-0.5', ".border-spacing-0.5{--tw-border-spacing-x:0.125rem;--tw-border-spacing-y:0.125rem;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-1.5', ".border-spacing-1.5{--tw-border-spacing-x:0.375rem;--tw-border-spacing-y:0.375rem;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-2.5', ".border-spacing-2.5{--tw-border-spacing-x:0.625rem;--tw-border-spacing-y:0.625rem;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            
            // Axis-specific spacing
            ['border-spacing-x-2', ".border-spacing-x-2{--tw-border-spacing-x:0.5rem;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-y-4', ".border-spacing-y-4{--tw-border-spacing-y:1rem;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            
            // Arbitrary values
            ['border-spacing-[2px]', ".border-spacing-\\[2px\\]{--tw-border-spacing-x:2px;--tw-border-spacing-y:2px;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-[0.5em]', ".border-spacing-\\[0\\.5em\\]{--tw-border-spacing-x:0.5em;--tw-border-spacing-y:0.5em;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-[3%]', ".border-spacing-\\[3\\%\\]{--tw-border-spacing-x:3%;--tw-border-spacing-y:3%;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-[calc(1rem+2px)]', ".border-spacing-\\[calc\\(1rem\\+2px\\)\\]{--tw-border-spacing-x:calc(1rem+2px);--tw-border-spacing-y:calc(1rem+2px);border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            
            // Arbitrary values with axis
            ['border-spacing-x-[5px]', ".border-spacing-x-\\[5px\\]{--tw-border-spacing-x:5px;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
            ['border-spacing-y-[1.5rem]', ".border-spacing-y-\\[1\\.5rem\\]{--tw-border-spacing-y:1.5rem;border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}"],
        ];
    }

    #[DataProvider('invalidBorderSpacingClassProvider')]
    public function testInvalidBorderSpacingClass(string $input): void
    {
        $borderSpacingClass = BorderSpacingClass::parse($input);
        $this->assertInstanceOf(BorderSpacingClass::class, $borderSpacingClass);
        $this->assertSame('', $borderSpacingClass->toCss());
    }

    public static function invalidBorderSpacingClassProvider(): array
    {
        return [
            ['border-spacing-invalid'],
            ['border-spacing-3px'],
            ['border-spacing-x-'],
            ['border-spacing-y-[]'],
            ['border-spacing-[10]'],
            ['border-spacing-[px]'],
            ['border-spacing-[2px'],
            ['border-spacing-2px]'],
        ];
    }

    public function testNonBorderSpacingClass(): void
    {
        $this->assertNull(BorderSpacingClass::parse('text-center'));
    }
}