<?php

namespace Raakkan\PhpTailwind\Tests\Interactivity;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Interactivity\WillChangeClass;

class WillChangeTest extends TestCase
{
    #[DataProvider('standardWillChangeProvider')]
    public function testStandardWillChange(string $input, string $expected): void
    {
        $willChangeClass = WillChangeClass::parse($input);
        $this->assertInstanceOf(WillChangeClass::class, $willChangeClass);
        $this->assertSame($expected, $willChangeClass->toCss());
    }

    public static function standardWillChangeProvider(): array
    {
        return [
            ['will-change-auto', '.will-change-auto{will-change:auto;}'],
            ['will-change-scroll', '.will-change-scroll{will-change:scroll-position;}'],
            ['will-change-contents', '.will-change-contents{will-change:contents;}'],
            ['will-change-transform', '.will-change-transform{will-change:transform;}'],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function testArbitraryValues(string $input, string $expected): void
    {
        $willChangeClass = WillChangeClass::parse($input);
        $this->assertInstanceOf(WillChangeClass::class, $willChangeClass);
        $this->assertSame($expected, $willChangeClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['will-change-[opacity]', '.will-change-\\[opacity\\]{will-change:opacity;}'],
            ['will-change-[top,_left]', '.will-change-\\[top\\2c _left\\]{will-change:top, left;}'],
            ['will-change-[margin,_padding]', '.will-change-\\[margin\\2c _padding\\]{will-change:margin, padding;}'],
            ['will-change-[transform,_opacity]', '.will-change-\\[transform\\2c _opacity\\]{will-change:transform, opacity;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $willChangeClass = WillChangeClass::parse($input);
        $this->assertNull($willChangeClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            // ['will-change-invalid'],
            ['will-change-123'],
            ['will-change-'],
            ['will-change'],
            ['change-will'],
            ['will-change-[invalid'],
            ['will-change-invalid]'],
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function testEdgeCases(string $input, string $expected): void
    {
        $willChangeClass = WillChangeClass::parse($input);
        $this->assertInstanceOf(WillChangeClass::class, $willChangeClass);
        $this->assertSame($expected, $willChangeClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['will-change-[auto]', '.will-change-\\[auto\\]{will-change:auto;}'],
            ['will-change-[scroll-position]', '.will-change-\\[scroll-position\\]{will-change:scroll-position;}'],
            ['will-change-[transform,opacity]', '.will-change-\\[transform\\2c opacity\\]{will-change:transform,opacity;}'],
            ['will-change-[margin,_padding,_color]', '.will-change-\\[margin\\2c _padding\\2c _color\\]{will-change:margin, padding, color;}'],
        ];
    }

    public function testEmptyOutput(): void
    {
        $willChangeClass = WillChangeClass::parse('will-change-invalid');
        $this->assertInstanceOf(WillChangeClass::class, $willChangeClass);
        $this->assertSame('', $willChangeClass->toCss());
    }
}
