<?php

namespace Raakkan\PhpTailwind\Tests\Transitions;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\TransitionAnimation\TransitionPropertyClass;

class TransitionPropertyTest extends TestCase
{
    #[DataProvider('standardTransitionProvider')]
    public function testStandardTransitions(string $input, string $expected): void
    {
        $transitionClass = TransitionPropertyClass::parse($input);
        $this->assertInstanceOf(TransitionPropertyClass::class, $transitionClass);
        $this->assertSame($expected, $transitionClass->toCss());
    }

    public static function standardTransitionProvider(): array
    {
        return [
            ['transition-none', '.transition-none{transition-property:none;}'],
            ['transition-all', '.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}'],
            ['transition', '.transition-DEFAULT{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}'],
            ['transition-colors', '.transition-colors{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}'],
            ['transition-opacity', '.transition-opacity{transition-property:opacity;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}'],
            ['transition-shadow', '.transition-shadow{transition-property:box-shadow;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}'],
            ['transition-transform', '.transition-transform{transition-property:transform;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}'],
        ];
    }

    #[DataProvider('arbitraryTransitionProvider')]
    public function testArbitraryTransitions(string $input, string $expected): void
    {
        $transitionClass = TransitionPropertyClass::parse($input);
        $this->assertInstanceOf(TransitionPropertyClass::class, $transitionClass);
        $this->assertSame($expected, $transitionClass->toCss());
    }

    public static function arbitraryTransitionProvider(): array
    {
        return [
            ['transition-[height]', '.transition-\[height\]{transition-property:height;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}'],
            ['transition-[color,opacity]', '.transition-\[color\2c opacity\]{transition-property:color,opacity;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}'],
            ['transition-[width,height,background-color]', '.transition-\[width\2c height\2c background-color\]{transition-property:width,height,background-color;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $transitionClass = TransitionPropertyClass::parse($input);
        $this->assertNull($transitionClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['transition-'],
            ['transition-invalid'],
            ['transition-['],
            ['transition-[]'],
            ['not-a-transition-class'],
            ['transform-all'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test case sensitivity
        $uppercaseTransition = TransitionPropertyClass::parse('TRANSITION-ALL');
        $this->assertNull($uppercaseTransition);

        // Test with extra spaces
        $extraSpacesTransition = TransitionPropertyClass::parse('transition-  [height]');
        $this->assertNull($extraSpacesTransition);

        // Test with multiple arbitrary properties
        $multipleArbitrary = TransitionPropertyClass::parse('transition-[width,height,color]');
        $this->assertInstanceOf(TransitionPropertyClass::class, $multipleArbitrary);
        $this->assertSame('.transition-\[width\2c height\2c color\]{transition-property:width,height,color;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}', $multipleArbitrary->toCss());

        // Test with arbitrary value containing special characters
        $specialCharsArbitrary = TransitionPropertyClass::parse('transition-[background-image,transform]');
        $this->assertInstanceOf(TransitionPropertyClass::class, $specialCharsArbitrary);
        $this->assertSame('.transition-\[background-image\2c transform\]{transition-property:background-image,transform;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;}', $specialCharsArbitrary->toCss());
    }
}
