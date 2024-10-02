<?php

namespace Raakkan\PhpTailwind\Tests\Transitions;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\TransitionAnimation\TransitionDurationClass;
use PHPUnit\Framework\Attributes\DataProvider;

class TransitionDurationTest extends TestCase
{
    #[DataProvider('standardDurationProvider')]
    public function testStandardDurations(string $input, string $expected): void
    {
        $durationClass = TransitionDurationClass::parse($input);
        $this->assertInstanceOf(TransitionDurationClass::class, $durationClass);
        $this->assertSame($expected, $durationClass->toCss());
    }

    public static function standardDurationProvider(): array
    {
        return [
            ['duration-75', '.duration-75{transition-duration:75ms;}'],
            ['duration-100', '.duration-100{transition-duration:100ms;}'],
            ['duration-150', '.duration-150{transition-duration:150ms;}'],
            ['duration-200', '.duration-200{transition-duration:200ms;}'],
            ['duration-300', '.duration-300{transition-duration:300ms;}'],
            ['duration-500', '.duration-500{transition-duration:500ms;}'],
            ['duration-700', '.duration-700{transition-duration:700ms;}'],
            ['duration-1000', '.duration-1000{transition-duration:1000ms;}'],
        ];
    }

    #[DataProvider('arbitraryDurationProvider')]
    public function testArbitraryDurations(string $input, string $expected): void
    {
        $durationClass = TransitionDurationClass::parse($input);
        $this->assertInstanceOf(TransitionDurationClass::class, $durationClass);
        $this->assertSame($expected, $durationClass->toCss());
    }

    public static function arbitraryDurationProvider(): array
    {
        return [
            ['duration-[2000ms]', '.duration-\[2000ms\]{transition-duration:2000ms;}'],
            ['duration-[2s]', '.duration-\[2s\]{transition-duration:2s;}'],
            ['duration-[1500ms]', '.duration-\[1500ms\]{transition-duration:1500ms;}'],
            ['duration-[.5s]', '.duration-\[\.5s\]{transition-duration:.5s;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $durationClass = TransitionDurationClass::parse($input);
        $this->assertNull($durationClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['duration-'],
            ['duration-50'],
            ['duration-['],
            ['duration-[]'],
            ['not-a-duration-class'],
            ['transition-75'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test case sensitivity
        $uppercaseDuration = TransitionDurationClass::parse('DURATION-75');
        $this->assertNull($uppercaseDuration);

        // Test with extra spaces
        $extraSpacesDuration = TransitionDurationClass::parse('duration-  [2000ms]');
        $this->assertNull($extraSpacesDuration);

        // Test with decimal arbitrary value
        $decimalArbitrary = TransitionDurationClass::parse('duration-[1.5s]');
        $this->assertInstanceOf(TransitionDurationClass::class, $decimalArbitrary);
        $this->assertSame('.duration-\[1\.5s\]{transition-duration:1.5s;}', $decimalArbitrary->toCss());

        // Test with arbitrary value containing special characters
        $specialCharsArbitrary = TransitionDurationClass::parse('duration-[calc(1s+500ms)]');
        $this->assertInstanceOf(TransitionDurationClass::class, $specialCharsArbitrary);
        $this->assertSame('.duration-\[calc\(1s\+500ms\)\]{transition-duration:calc(1s+500ms);}', $specialCharsArbitrary->toCss());
    }
}