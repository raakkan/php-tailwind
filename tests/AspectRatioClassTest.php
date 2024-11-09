<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Layout\AspectRatioClass;

class AspectRatioClassTest extends TestCase
{
    #[DataProvider('aspectRatioClassProvider')]
    public function testAspectRatioClass(string $input, string $expected): void
    {
        $aspectRatioClass = AspectRatioClass::parse($input);
        $this->assertInstanceOf(AspectRatioClass::class, $aspectRatioClass);
        $this->assertSame($expected, $aspectRatioClass->toCss());
    }

    public static function aspectRatioClassProvider(): array
    {
        return [
            ['aspect-auto', '.aspect-auto{aspect-ratio:auto;}'],
            ['aspect-square', '.aspect-square{aspect-ratio:1/1;}'],
            ['aspect-video', '.aspect-video{aspect-ratio:16/9;}'],
            ['aspect-[4/3]', '.aspect-\[4\/3\]{aspect-ratio:4/3;}'],
            ['aspect-[16/9]', '.aspect-\[16\/9\]{aspect-ratio:16/9;}'],
            ['aspect-[2.35/1]', '.aspect-\[2\.35\/1\]{aspect-ratio:2.35/1;}'],
            ['aspect-[1.5]', '.aspect-\[1\.5\]{aspect-ratio:1.5;}'],
        ];
    }

    public function testInvalidAspectRatioClass(): void
    {
        $this->assertNull(AspectRatioClass::parse('aspect-invalid'));
    }

    public function testAspectRatioClassWithInvalidValue(): void
    {
        $aspectRatioClass = new AspectRatioClass('invalid');
        $this->assertSame('', $aspectRatioClass->toCss());
    }

    public function testArbitraryAspectRatioValidation(): void
    {
        $this->assertInstanceOf(AspectRatioClass::class, AspectRatioClass::parse('aspect-[1.5]'));
        $this->assertInstanceOf(AspectRatioClass::class, AspectRatioClass::parse('aspect-[3/2]'));
        $this->assertInstanceOf(AspectRatioClass::class, AspectRatioClass::parse('aspect-[1.5/1]'));
    }

    private function compress(string $css): string
    {
        return preg_replace('/\s+/', '', $css);
    }
}
