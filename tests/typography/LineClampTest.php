<?php

namespace Raakkan\PhpTailwind\Tests\Typography;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Typography\LineClampClass;

class LineClampTest extends TestCase
{
    #[DataProvider('lineClampClassProvider')]
    public function test_line_clamp_class(string $input, string $expected): void
    {
        $lineClampClass = LineClampClass::parse($input);
        $this->assertInstanceOf(LineClampClass::class, $lineClampClass);
        $this->assertSame($expected, $lineClampClass->toCss());
    }

    public static function lineClampClassProvider(): array
    {
        return [
            // Predefined values
            ['line-clamp-1', '.line-clamp-1{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:1;}'],
            ['line-clamp-2', '.line-clamp-2{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;}'],
            ['line-clamp-3', '.line-clamp-3{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:3;}'],
            ['line-clamp-4', '.line-clamp-4{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:4;}'],
            ['line-clamp-5', '.line-clamp-5{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:5;}'],
            ['line-clamp-6', '.line-clamp-6{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:6;}'],
            ['line-clamp-none', '.line-clamp-none{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:none;}'],

            // Arbitrary values
            ['line-clamp-[3]', '.line-clamp-\[3\]{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:3;}'],
            ['line-clamp-[10]', '.line-clamp-\[10\]{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:10;}'],
        ];
    }

    public function test_invalid_line_clamp_class(): void
    {
        $this->assertNull(LineClampClass::parse('line-clamp-invalid'));
    }

    #[DataProvider('invalidLineClampProvider')]
    public function test_invalid_line_clamp(string $input): void
    {
        $lineClampClass = LineClampClass::parse($input);
        $this->assertInstanceOf(LineClampClass::class, $lineClampClass);
        $this->assertSame('', $lineClampClass->toCss());
    }

    public static function invalidLineClampProvider(): array
    {
        return [
            // ['line-clamp-0'],
            // ['line-clamp-7'],
            // ['line-clamp-[0]'],
            ['line-clamp-[-1]'],
            ['line-clamp-[abc]'],
        ];
    }

    #[DataProvider('validArbitraryLineClampProvider')]
    public function test_valid_arbitrary_line_clamp(string $input, string $expected): void
    {
        $lineClampClass = LineClampClass::parse($input);
        $this->assertInstanceOf(LineClampClass::class, $lineClampClass);
        $this->assertSame($expected, $lineClampClass->toCss());
    }

    public static function validArbitraryLineClampProvider(): array
    {
        return [
            ['line-clamp-[1]', '.line-clamp-\[1\]{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:1;}'],
            ['line-clamp-[20]', '.line-clamp-\[20\]{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:20;}'],
            ['line-clamp-[100]', '.line-clamp-\[100\]{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:100;}'],
        ];
    }

    // #[DataProvider('edgeCaseLineClampProvider')]
    // public function testEdgeCaseLineClamp(string $input, string $expected): void
    // {
    //     $lineClampClass = LineClampClass::parse($input);
    //     $this->assertInstanceOf(LineClampClass::class, $lineClampClass);
    //     $this->assertSame($expected, $lineClampClass->toCss());
    // }

    // public static function edgeCaseLineClampProvider(): array
    // {
    //     return [
    //         ['line-clamp-[1.5]', '.line-clamp-\[1\.5\]{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:1.5;}'],
    //         ['line-clamp-[0.5]', ''], // Should be invalid
    //         ['line-clamp-[999999]', '.line-clamp-\[999999\]{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:999999;}'],
    //     ];
    // }

    // #[DataProvider('specialCharactersLineClampProvider')]
    // public function testSpecialCharactersLineClamp(string $input, string $expected): void
    // {
    //     $lineClampClass = LineClampClass::parse($input);
    //     $this->assertInstanceOf(LineClampClass::class, $lineClampClass);
    //     $this->assertSame($expected, $lineClampClass->toCss());
    // }

    // public static function specialCharactersLineClampProvider(): array
    // {
    //     return [
    //         ['line-clamp-[3!important]', '.line-clamp-\[3\!important\]{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:3!important;}'],
    //         ['line-clamp-[calc(2+1)]', '.line-clamp-\[calc\(2\+1\)\]{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:calc(2+1);}'],
    //     ];
    // }
}
