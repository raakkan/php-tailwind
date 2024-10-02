<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\LetterSpacingClass;
use PHPUnit\Framework\Attributes\DataProvider;

class LetterSpacingTest extends TestCase
{
    #[DataProvider('letterSpacingClassProvider')]
    public function testLetterSpacingClass(string $input, string $expected): void
    {
        $letterSpacingClass = LetterSpacingClass::parse($input);
        $this->assertInstanceOf(LetterSpacingClass::class, $letterSpacingClass);
        $this->assertSame($expected, $letterSpacingClass->toCss());
    }

    public static function letterSpacingClassProvider(): array
    {
        return [
            // Predefined values
            ['tracking-tighter', '.tracking-tighter{letter-spacing:-0.05em;}'],
            ['tracking-tight', '.tracking-tight{letter-spacing:-0.025em;}'],
            ['tracking-normal', '.tracking-normal{letter-spacing:0em;}'],
            ['tracking-wide', '.tracking-wide{letter-spacing:0.025em;}'],
            ['tracking-wider', '.tracking-wider{letter-spacing:0.05em;}'],
            ['tracking-widest', '.tracking-widest{letter-spacing:0.1em;}'],

            // Arbitrary values
            ['tracking-[.25em]', '.tracking-\[\.25em\]{letter-spacing:.25em;}'],
            ['tracking-[-.05em]', '.tracking-\[-\.05em\]{letter-spacing:-.05em;}'],
            ['tracking-[3px]', '.tracking-\[3px\]{letter-spacing:3px;}'],
            ['tracking-[-2px]', '.tracking-\[-2px\]{letter-spacing:-2px;}'],
        ];
    }

    public function testInvalidLetterSpacingClass(): void
    {
        $this->assertNull(LetterSpacingClass::parse('tracking-invalid'));
    }

    #[DataProvider('invalidArbitraryLetterSpacingProvider')]
    public function testInvalidArbitraryLetterSpacing(string $input): void
    {
        $letterSpacingClass = LetterSpacingClass::parse($input);
        $this->assertInstanceOf(LetterSpacingClass::class, $letterSpacingClass);
        $this->assertSame('', $letterSpacingClass->toCss());
    }

    public static function invalidArbitraryLetterSpacingProvider(): array
    {
        return [
            ['tracking-[invalid]'],
            ['tracking-[abc]'],
            // ['tracking-[]'],
        ];
    }

    // #[DataProvider('validArbitraryLetterSpacingProvider')]
    // public function testValidArbitraryLetterSpacing(string $input, string $expected): void
    // {
    //     $letterSpacingClass = LetterSpacingClass::parse($input);
    //     $this->assertInstanceOf(LetterSpacingClass::class, $letterSpacingClass);
    //     $this->assertSame($expected, $letterSpacingClass->toCss());
    // }

    // public static function validArbitraryLetterSpacingProvider(): array
    // {
    //     return [
    //         ['tracking-[0.5em]', '.tracking-\[0\.5em\]{letter-spacing:0.5em;}'],
    //         ['tracking-[-1px]', '.tracking-\[-1px\]{letter-spacing:-1px;}'],
    //         ['tracking-[2rem]', '.tracking-\[2rem\]{letter-spacing:2rem;}'],
    //         ['tracking-[.5vw]', '.tracking-\[\.5vw\]{letter-spacing:.5vw;}'],
    //     ];
    // }

    // public function testNonTrackingClass(): void
    // {
    //     $this->assertNull(LetterSpacingClass::parse('font-bold'));
    // }

    // #[DataProvider('edgeCaseArbitraryLetterSpacingProvider')]
    // public function testEdgeCaseArbitraryLetterSpacing(string $input, string $expected): void
    // {
    //     $letterSpacingClass = LetterSpacingClass::parse($input);
    //     $this->assertInstanceOf(LetterSpacingClass::class, $letterSpacingClass);
    //     $this->assertSame($expected, $letterSpacingClass->toCss());
    // }

    // public static function edgeCaseArbitraryLetterSpacingProvider(): array
    // {
    //     return [
    //         ['tracking-[0]', '.tracking-\[0\]{letter-spacing:0;}'],
    //         ['tracking-[.01em]', '.tracking-\[\.01em\]{letter-spacing:.01em;}'],
    //         ['tracking-[-0.1px]', '.tracking-\[-0\.1px\]{letter-spacing:-0.1px;}'],
    //     ];
    // }

    // #[DataProvider('specialCharactersLetterSpacingProvider')]
    // public function testSpecialCharactersLetterSpacing(string $input, string $expected): void
    // {
    //     $letterSpacingClass = LetterSpacingClass::parse($input);
    //     $this->assertInstanceOf(LetterSpacingClass::class, $letterSpacingClass);
    //     $this->assertSame($expected, $letterSpacingClass->toCss());
    // }

    // public static function specialCharactersLetterSpacingProvider(): array
    // {
    //     return [
    //         ['tracking-[calc(1em+2px)]', '.tracking-\[calc\(1em\+2px\)\]{letter-spacing:calc(1em+2px);}'],
    //         ['tracking-[var(--spacing)]', '.tracking-\[var\(--spacing\)\]{letter-spacing:var(--spacing);}'],
    //         ['tracking-[clamp(1px,2em,3rem)]', '.tracking-\[clamp\(1px\,2em\,3rem\)\]{letter-spacing:clamp(1px,2em,3rem);}'],
    //     ];
    // }
}