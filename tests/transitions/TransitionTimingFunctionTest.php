<?php

namespace Raakkan\PhpTailwind\Tests\Transitions;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\TransitionAnimation\TransitionTimingFunctionClass;
use PHPUnit\Framework\Attributes\DataProvider;

class TransitionTimingFunctionTest extends TestCase
{
    #[DataProvider('standardTimingFunctionProvider')]
    public function testStandardTimingFunctions(string $input, string $expected): void
    {
        $timingFunctionClass = TransitionTimingFunctionClass::parse($input);
        $this->assertInstanceOf(TransitionTimingFunctionClass::class, $timingFunctionClass);
        $this->assertSame($expected, $timingFunctionClass->toCss());
    }

    public static function standardTimingFunctionProvider(): array
    {
        return [
            ['ease-linear', '.ease-linear{transition-timing-function:linear;}'],
            ['ease-in', '.ease-in{transition-timing-function:cubic-bezier(0.4, 0, 1, 1);}'],
            ['ease-out', '.ease-out{transition-timing-function:cubic-bezier(0, 0, 0.2, 1);}'],
            ['ease-in-out', '.ease-in-out{transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);}'],
        ];
    }

    #[DataProvider('arbitraryTimingFunctionProvider')]
    public function testArbitraryTimingFunctions(string $input, string $expected): void
    {
        $timingFunctionClass = TransitionTimingFunctionClass::parse($input);
        $this->assertInstanceOf(TransitionTimingFunctionClass::class, $timingFunctionClass);
        $this->assertSame($expected, $timingFunctionClass->toCss());
    }

    public static function arbitraryTimingFunctionProvider(): array
    {
        return [
            ['ease-[cubic-bezier(0.95,0.05,0.795,0.035)]', '.ease-\[cubic-bezier\(0\.95\2c 0\.05\2c 0\.795\2c 0\.035\)\]{transition-timing-function:cubic-bezier(0.95,0.05,0.795,0.035);}'],
            ['ease-[cubic-bezier(0,1,0,1)]', '.ease-\[cubic-bezier\(0\2c 1\2c 0\2c 1\)\]{transition-timing-function:cubic-bezier(0,1,0,1);}'],
            ['ease-[cubic-bezier(0.25,0.1,0.25,1)]', '.ease-\[cubic-bezier\(0\.25\2c 0\.1\2c 0\.25\2c 1\)\]{transition-timing-function:cubic-bezier(0.25,0.1,0.25,1);}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $timingFunctionClass = TransitionTimingFunctionClass::parse($input);
        $this->assertNull($timingFunctionClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['ease-'],
            ['ease-invalid'],
            ['ease-['],
            ['ease-[]'],
            ['not-a-timing-function-class'],
            ['ease-[linear]'],
            ['ease-[cubic-bezier()]'],
            ['ease-[cubic-bezier(0,0,0)]'],
            ['ease-[cubic-bezier(0,0,0,0,0)]'],
            ['ease-[cubic-bezier(-0.1,0,0,1)]'],
            ['ease-[cubic-bezier(0,1.1,0,1)]'],
            ['ease-[cubic-bezier(a,b,c,d)]'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test case sensitivity
        $uppercaseEase = TransitionTimingFunctionClass::parse('EASE-LINEAR');
        $this->assertNull($uppercaseEase);

        // Test with extra spaces
        $extraSpacesEase = TransitionTimingFunctionClass::parse('ease-  [cubic-bezier(0,1,0,1)]');
        $this->assertNull($extraSpacesEase);

        // Test with spaces in cubic-bezier function
        $spacesInFunction = TransitionTimingFunctionClass::parse('ease-[cubic-bezier(0.1, 0.7, 1.0, 0.1)]');
        $this->assertInstanceOf(TransitionTimingFunctionClass::class, $spacesInFunction);
        $this->assertSame('.ease-\[cubic-bezier\(0\.1\2c  0\.7\2c  1\.0\2c  0\.1\)\]{transition-timing-function:cubic-bezier(0.1, 0.7, 1.0, 0.1);}', $spacesInFunction->toCss());

        // Test with integer values
        $integerValues = TransitionTimingFunctionClass::parse('ease-[cubic-bezier(0,1,0,1)]');
        $this->assertInstanceOf(TransitionTimingFunctionClass::class, $integerValues);
        $this->assertSame('.ease-\[cubic-bezier\(0\2c 1\2c 0\2c 1\)\]{transition-timing-function:cubic-bezier(0,1,0,1);}', $integerValues->toCss());

        // Test with leading zeros
        $leadingZeros = TransitionTimingFunctionClass::parse('ease-[cubic-bezier(0.00,0.50,1.00,0.10)]');
        $this->assertInstanceOf(TransitionTimingFunctionClass::class, $leadingZeros);
        $this->assertSame('.ease-\[cubic-bezier\(0\.00\2c 0\.50\2c 1\.00\2c 0\.10\)\]{transition-timing-function:cubic-bezier(0.00,0.50,1.00,0.10);}', $leadingZeros->toCss());
    }
}