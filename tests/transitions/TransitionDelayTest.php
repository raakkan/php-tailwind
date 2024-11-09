<?php

namespace Raakkan\PhpTailwind\Tests\Transitions;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\TransitionAnimation\TransitionDelayClass;

class TransitionDelayTest extends TestCase
{
    #[DataProvider('standardDelayProvider')]
    public function testStandardDelays(string $input, string $expected): void
    {
        $delayClass = TransitionDelayClass::parse($input);
        $this->assertInstanceOf(TransitionDelayClass::class, $delayClass);
        $this->assertSame($expected, $delayClass->toCss());
    }

    public static function standardDelayProvider(): array
    {
        return [
            ['delay-0', '.delay-0{transition-delay:0s;}'],
            ['delay-75', '.delay-75{transition-delay:75ms;}'],
            ['delay-100', '.delay-100{transition-delay:100ms;}'],
            ['delay-150', '.delay-150{transition-delay:150ms;}'],
            ['delay-200', '.delay-200{transition-delay:200ms;}'],
            ['delay-300', '.delay-300{transition-delay:300ms;}'],
            ['delay-500', '.delay-500{transition-delay:500ms;}'],
            ['delay-700', '.delay-700{transition-delay:700ms;}'],
            ['delay-1000', '.delay-1000{transition-delay:1000ms;}'],
        ];
    }

    #[DataProvider('arbitraryDelayProvider')]
    public function testArbitraryDelays(string $input, string $expected): void
    {
        $delayClass = TransitionDelayClass::parse($input);
        $this->assertInstanceOf(TransitionDelayClass::class, $delayClass);
        $this->assertSame($expected, $delayClass->toCss());
    }

    public static function arbitraryDelayProvider(): array
    {
        return [
            ['delay-[2000ms]', '.delay-\[2000ms\]{transition-delay:2000ms;}'],
            ['delay-[2s]', '.delay-\[2s\]{transition-delay:2s;}'],
            ['delay-[1500ms]', '.delay-\[1500ms\]{transition-delay:1500ms;}'],
            ['delay-[.5s]', '.delay-\[\.5s\]{transition-delay:.5s;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $delayClass = TransitionDelayClass::parse($input);
        $this->assertNull($delayClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['delay-'],
            ['delay-50'],
            ['delay-['],
            ['delay-[]'],
            ['not-a-delay-class'],
            ['transition-75'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test case sensitivity
        $uppercaseDelay = TransitionDelayClass::parse('DELAY-75');
        $this->assertNull($uppercaseDelay);

        // Test with extra spaces
        $extraSpacesDelay = TransitionDelayClass::parse('delay-  [2000ms]');
        $this->assertNull($extraSpacesDelay);

        // Test with decimal arbitrary value
        $decimalArbitrary = TransitionDelayClass::parse('delay-[1.5s]');
        $this->assertInstanceOf(TransitionDelayClass::class, $decimalArbitrary);
        $this->assertSame('.delay-\[1\.5s\]{transition-delay:1.5s;}', $decimalArbitrary->toCss());

        // Test with arbitrary value containing special characters
        $specialCharsArbitrary = TransitionDelayClass::parse('delay-[calc(1s+500ms)]');
        $this->assertInstanceOf(TransitionDelayClass::class, $specialCharsArbitrary);
        $this->assertSame('.delay-\[calc\(1s\+500ms\)\]{transition-delay:calc(1s+500ms);}', $specialCharsArbitrary->toCss());
    }
}
