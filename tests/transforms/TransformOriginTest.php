<?php

namespace Raakkan\PhpTailwind\Tests\Transforms;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Transforms\TransformOriginClass;

class TransformOriginTest extends TestCase
{
    #[DataProvider('standardOriginProvider')]
    public function test_standard_origin(string $input, string $expected): void
    {
        $originClass = TransformOriginClass::parse($input);
        $this->assertInstanceOf(TransformOriginClass::class, $originClass);
        $this->assertSame($expected, $originClass->toCss());
    }

    public static function standardOriginProvider(): array
    {
        return [
            ['origin-center', '.origin-center{transform-origin:center;}'],
            ['origin-top', '.origin-top{transform-origin:top;}'],
            ['origin-top-right', '.origin-top-right{transform-origin:top right;}'],
            ['origin-right', '.origin-right{transform-origin:right;}'],
            ['origin-bottom-right', '.origin-bottom-right{transform-origin:bottom right;}'],
            ['origin-bottom', '.origin-bottom{transform-origin:bottom;}'],
            ['origin-bottom-left', '.origin-bottom-left{transform-origin:bottom left;}'],
            ['origin-left', '.origin-left{transform-origin:left;}'],
            ['origin-top-left', '.origin-top-left{transform-origin:top left;}'],
        ];
    }

    #[DataProvider('arbitraryOriginProvider')]
    public function test_arbitrary_origin(string $input, string $expected): void
    {
        $originClass = TransformOriginClass::parse($input);
        $this->assertInstanceOf(TransformOriginClass::class, $originClass);
        $this->assertSame($expected, $originClass->toCss());
    }

    public static function arbitraryOriginProvider(): array
    {
        return [
            ['origin-[33%_75%]', '.origin-\[33\%_75\%\]{transform-origin:33% 75%;}'],
            ['origin-[center_bottom]', '.origin-\[center_bottom\]{transform-origin:center bottom;}'],
            ['origin-[top_right_5px]', '.origin-\[top_right_5px\]{transform-origin:top right 5px;}'],
            ['origin-[25%]', '.origin-\[25\%\]{transform-origin:25%;}'],
            ['origin-[7rem]', '.origin-\[7rem\]{transform-origin:7rem;}'],
            ['origin-[2.5in]', '.origin-\[2\.5in\]{transform-origin:2.5in;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function test_invalid_inputs(string $input): void
    {
        $originClass = TransformOriginClass::parse($input);
        $this->assertNull($originClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['origin'],
            ['origin-'],
            ['origin-top-center'],
            ['origin-middle'],
            ['origin-['],
            ['origin-[]'],
            ['not-an-origin-class'],
            ['transform-origin-center'],
        ];
    }

    public function test_edge_cases(): void
    {
        // Test case sensitivity
        $upperCaseOrigin = TransformOriginClass::parse('origin-TOP-RIGHT');
        $this->assertNull($upperCaseOrigin);

        // Test arbitrary value with spaces and special characters
        $complexArbitrary = TransformOriginClass::parse('origin-[calc(50%_+_25px)_50%]');
        $this->assertInstanceOf(TransformOriginClass::class, $complexArbitrary);
        $this->assertSame('.origin-\[calc\(50\%_\+_25px\)_50\%\]{transform-origin:calc(50% + 25px) 50%;}', $complexArbitrary->toCss());

        // Test arbitrary value with quotes
        // $quotedArbitrary = TransformOriginClass::parse('origin-["top_left"]');
        // $this->assertInstanceOf(TransformOriginClass::class, $quotedArbitrary);
        // $this->assertSame('.origin-\["top_left"\]{transform-origin:"top left";}', $quotedArbitrary->toCss());

        // Test empty arbitrary value
        $emptyArbitrary = TransformOriginClass::parse('origin-[]');
        $this->assertNull($emptyArbitrary);
    }
}
