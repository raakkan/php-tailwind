<?php

namespace Raakkan\PhpTailwind\Tests\Transitions;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\TransitionAnimation\AnimationClass;

class AnimationTest extends TestCase
{
    #[DataProvider('standardAnimationProvider')]
    public function testStandardAnimations(string $input, string $expected): void
    {
        $animationClass = AnimationClass::parse($input);
        $this->assertInstanceOf(AnimationClass::class, $animationClass);
        $this->assertSame($expected, $animationClass->toCss());
    }

    public static function standardAnimationProvider(): array
    {
        return [
            ['animate-none', '.animate-none{animation:none;}'],
            ['animate-spin', '.animate-spin{animation:spin 1s linear infinite;}@keyframes spin{to{transform:rotate(360deg);}}'],
            ['animate-ping', '.animate-ping{animation:ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;}@keyframes ping{75%,100%{transform:scale(2);opacity:0;}}'],
            ['animate-pulse', '.animate-pulse{animation:pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;}@keyframes pulse{50%{opacity:.5;}}'],
            ['animate-bounce', '.animate-bounce{animation:bounce 1s infinite;}@keyframes bounce{0%,100%{transform:translateY(-25%);animation-timing-function:cubic-bezier(0.8,0,1,1);}50%{transform:none;animation-timing-function:cubic-bezier(0,0,0.2,1);}}'],
        ];
    }

    #[DataProvider('arbitraryAnimationProvider')]
    public function testArbitraryAnimations(string $input, string $expected): void
    {
        $animationClass = AnimationClass::parse($input);
        $this->assertInstanceOf(AnimationClass::class, $animationClass);
        $this->assertSame($expected, $animationClass->toCss());
    }

    public static function arbitraryAnimationProvider(): array
    {
        return [
            ['animate-[wiggle_1s_ease-in-out_infinite]', '.animate-\[wiggle_1s_ease-in-out_infinite\]{animation:wiggle 1s ease-in-out infinite;}'],
            ['animate-[shake_0.5s_ease-in-out]', '.animate-\[shake_0\.5s_ease-in-out\]{animation:shake 0.5s ease-in-out;}'],
            ['animate-[fade-in_2s_ease]', '.animate-\[fade-in_2s_ease\]{animation:fade-in 2s ease;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $animationClass = AnimationClass::parse($input);
        $this->assertNull($animationClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['animate-'],
            ['animate-invalid'],
            ['animate-['],
            ['animate-[]'],
            ['not-an-animation-class'],
            ['transition-all'],
        ];
    }

    public function testEdgeCases(): void
    {
        // Test case sensitivity
        $uppercaseAnimation = AnimationClass::parse('ANIMATE-SPIN');
        $this->assertNull($uppercaseAnimation);

        // Test with extra spaces
        $extraSpacesAnimation = AnimationClass::parse('animate-  [wiggle]');
        $this->assertNull($extraSpacesAnimation);

        // Test with multiple arbitrary properties
        $multipleArbitrary = AnimationClass::parse('animate-[fade-in,scale-up]');
        $this->assertInstanceOf(AnimationClass::class, $multipleArbitrary);
        $this->assertSame('.animate-\[fade-in\2c scale-up\]{animation:fade-in,scale-up;}', $multipleArbitrary->toCss());

        // Test with arbitrary value containing special characters
        $specialCharsArbitrary = AnimationClass::parse('animate-[custom@keyframe_0.5s_ease-in-out]');
        $this->assertInstanceOf(AnimationClass::class, $specialCharsArbitrary);
        $this->assertSame('.animate-\[custom\@keyframe_0\.5s_ease-in-out\]{animation:custom@keyframe 0.5s ease-in-out;}', $specialCharsArbitrary->toCss());
    }

    public function testKeyframesGeneration(): void
    {
        $spinAnimation = AnimationClass::parse('animate-spin');
        $this->assertStringContainsString('@keyframes spin{to{transform:rotate(360deg);}}', $spinAnimation->toCss());

        $pingAnimation = AnimationClass::parse('animate-ping');
        $this->assertStringContainsString('@keyframes ping{75%,100%{transform:scale(2);opacity:0;}}', $pingAnimation->toCss());

        $pulseAnimation = AnimationClass::parse('animate-pulse');
        $this->assertStringContainsString('@keyframes pulse{50%{opacity:.5;}}', $pulseAnimation->toCss());

        $bounceAnimation = AnimationClass::parse('animate-bounce');
        $this->assertStringContainsString('@keyframes bounce{0%,100%{transform:translateY(-25%);animation-timing-function:cubic-bezier(0.8,0,1,1);}50%{transform:none;animation-timing-function:cubic-bezier(0,0,0.2,1);}}', $bounceAnimation->toCss());

        $arbitraryAnimation = AnimationClass::parse('animate-[custom_1s_ease]');
        $this->assertStringNotContainsString('@keyframes', $arbitraryAnimation->toCss());
    }
}
