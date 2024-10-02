<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Layout\ObjectPositionClass;
use PHPUnit\Framework\Attributes\DataProvider;

class ObjectPositionClassTest extends TestCase
{
    #[DataProvider('objectPositionClassProvider')]
    public function testObjectPositionClass(string $input, string $expected): void
    {
        $objectPositionClass = ObjectPositionClass::parse($input);
        $this->assertInstanceOf(ObjectPositionClass::class, $objectPositionClass);
        $this->assertSame($expected, $objectPositionClass->toCss());
    }

    public static function objectPositionClassProvider(): array
    {
        return [
            ['object-left-top', '.object-left-top{object-position:left top;}'],
            ['object-top', '.object-top{object-position:top;}'],
            ['object-right-bottom', '.object-right-bottom{object-position:right bottom;}'],
            ['object-center', '.object-center{object-position:center;}'],
            ['object-left', '.object-left{object-position:left;}'],
            ['object-right', '.object-right{object-position:right;}'],
            ['object-bottom', '.object-bottom{object-position:bottom;}'],
            ['object-top-right', '.object-top-right{object-position:top right;}'],
            ['object-top-left', '.object-top-left{object-position:top left;}'],
            ['object-bottom-right', '.object-bottom-right{object-position:bottom right;}'],
            ['object-bottom-left', '.object-bottom-left{object-position:bottom left;}'],
            ['object-[50%_50%]', '.object-\[50\%_50\%\]{object-position:50% 50%;}'],
            ['object-[10px_20px]', '.object-\[10px_20px\]{object-position:10px 20px;}'],
            ['object-[center_bottom]', '.object-\[center_bottom\]{object-position:center bottom;}'],
            ['object-[right_10px_top_20%]', '.object-\[right_10px_top_20\%\]{object-position:right 10px top 20%;}'],
            ['object-[1em_2rem]', '.object-\[1em_2rem\]{object-position:1em 2rem;}'],
            ['object-[5vw_10vh]', '.object-\[5vw_10vh\]{object-position:5vw 10vh;}'],
            ['object-[2cm_3mm]', '.object-\[2cm_3mm\]{object-position:2cm 3mm;}'],
            ['object-[1in_2pt_3pc]', '.object-\[1in_2pt_3pc\]{object-position:1in 2pt 3pc;}'],
            ['object-[1ex_2ch]', '.object-\[1ex_2ch\]{object-position:1ex 2ch;}'],
            ['object-[auto]', '.object-\[auto\]{object-position:auto;}'],
            ['object-[inherit]', '.object-\[inherit\]{object-position:inherit;}'],
            ['object-[initial]', '.object-\[initial\]{object-position:initial;}'],
            ['object-[revert]', '.object-\[revert\]{object-position:revert;}'],
            ['object-[revert-layer]', '.object-\[revert-layer\]{object-position:revert-layer;}'],
            ['object-[unset]', '.object-\[unset\]{object-position:unset;}'],
            ['object-[-10px_-20%]', '.object-\[-10px_-20\%\]{object-position:-10px -20%;}'],
            ['object-[0.5_0.5]', '.object-\[0\.5_0\.5\]{object-position:0.5 0.5;}'],
        ];
    }

    public function testInvalidObjectPositionClass(): void
    {
        $this->assertNull(ObjectPositionClass::parse('object-invalid'));
    }

    public function testObjectPositionClassWithInvalidValue(): void
    {
        $objectPositionClass = ObjectPositionClass::parse('object-[invalid]');
        $this->assertSame('', $objectPositionClass->toCss());
    }
}