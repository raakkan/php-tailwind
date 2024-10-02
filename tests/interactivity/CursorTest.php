<?php

namespace Raakkan\PhpTailwind\Tests\Interactivity;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Interactivity\CursorClass;
use PHPUnit\Framework\Attributes\DataProvider;

class CursorTest extends TestCase
{
    #[DataProvider('standardCursorProvider')]
    public function testStandardCursors(string $input, string $expected): void
    {
        $cursorClass = CursorClass::parse($input);
        $this->assertInstanceOf(CursorClass::class, $cursorClass);
        $this->assertSame($expected, $cursorClass->toCss());
    }

    public static function standardCursorProvider(): array
    {
        return [
            ['cursor-auto', '.cursor-auto{cursor:auto;}'],
            ['cursor-default', '.cursor-default{cursor:default;}'],
            ['cursor-pointer', '.cursor-pointer{cursor:pointer;}'],
            ['cursor-wait', '.cursor-wait{cursor:wait;}'],
            ['cursor-text', '.cursor-text{cursor:text;}'],
            ['cursor-move', '.cursor-move{cursor:move;}'],
            ['cursor-help', '.cursor-help{cursor:help;}'],
            ['cursor-not-allowed', '.cursor-not-allowed{cursor:not-allowed;}'],
            ['cursor-none', '.cursor-none{cursor:none;}'],
            ['cursor-context-menu', '.cursor-context-menu{cursor:context-menu;}'],
            ['cursor-progress', '.cursor-progress{cursor:progress;}'],
            ['cursor-cell', '.cursor-cell{cursor:cell;}'],
            ['cursor-crosshair', '.cursor-crosshair{cursor:crosshair;}'],
            ['cursor-vertical-text', '.cursor-vertical-text{cursor:vertical-text;}'],
            ['cursor-alias', '.cursor-alias{cursor:alias;}'],
            ['cursor-copy', '.cursor-copy{cursor:copy;}'],
            ['cursor-no-drop', '.cursor-no-drop{cursor:no-drop;}'],
            ['cursor-grab', '.cursor-grab{cursor:grab;}'],
            ['cursor-grabbing', '.cursor-grabbing{cursor:grabbing;}'],
            ['cursor-all-scroll', '.cursor-all-scroll{cursor:all-scroll;}'],
            ['cursor-col-resize', '.cursor-col-resize{cursor:col-resize;}'],
            ['cursor-row-resize', '.cursor-row-resize{cursor:row-resize;}'],
            ['cursor-n-resize', '.cursor-n-resize{cursor:n-resize;}'],
            ['cursor-e-resize', '.cursor-e-resize{cursor:e-resize;}'],
            ['cursor-s-resize', '.cursor-s-resize{cursor:s-resize;}'],
            ['cursor-w-resize', '.cursor-w-resize{cursor:w-resize;}'],
            ['cursor-ne-resize', '.cursor-ne-resize{cursor:ne-resize;}'],
            ['cursor-nw-resize', '.cursor-nw-resize{cursor:nw-resize;}'],
            ['cursor-se-resize', '.cursor-se-resize{cursor:se-resize;}'],
            ['cursor-sw-resize', '.cursor-sw-resize{cursor:sw-resize;}'],
            ['cursor-ew-resize', '.cursor-ew-resize{cursor:ew-resize;}'],
            ['cursor-ns-resize', '.cursor-ns-resize{cursor:ns-resize;}'],
            ['cursor-nesw-resize', '.cursor-nesw-resize{cursor:nesw-resize;}'],
            ['cursor-nwse-resize', '.cursor-nwse-resize{cursor:nwse-resize;}'],
            ['cursor-zoom-in', '.cursor-zoom-in{cursor:zoom-in;}'],
            ['cursor-zoom-out', '.cursor-zoom-out{cursor:zoom-out;}'],
        ];
    }

    #[DataProvider('arbitraryValueProvider')]
    public function testArbitraryValues(string $input, string $expected): void
    {
        $cursorClass = CursorClass::parse($input);
        $this->assertInstanceOf(CursorClass::class, $cursorClass);
        $this->assertSame($expected, $cursorClass->toCss());
    }

    public static function arbitraryValueProvider(): array
    {
        return [
            ['cursor-[url(hand.cur),_pointer]', '.cursor-\\[url\\(hand\\.cur\\)\\2c _pointer\\]{cursor:url(hand.cur), pointer;}'],
            ['cursor-[url(hand.svg)_2_2,_pointer]', '.cursor-\\[url\\(hand\\.svg\\)_2_2\\2c _pointer\\]{cursor:url(hand.svg) 2 2, pointer;}'],
            ['cursor-[grab]', '.cursor-\\[grab\\]{cursor:grab;}'],
            // ['cursor-[url(https://example.com/cursor.png)_0_0,_auto]', '.cursor-\\[url\\(https\\3a //example\\.com/cursor\\.png\\)_0_0\\2c _auto\\]{cursor:url(https://example.com/cursor.png) 0 0, auto;}'],
        ];
    }

    #[DataProvider('invalidInputProvider')]
    public function testInvalidInputs(string $input): void
    {
        $cursorClass = CursorClass::parse($input);
        $this->assertNull($cursorClass);
    }

    public static function invalidInputProvider(): array
    {
        return [
            // ['cursor-invalid'],
            ['cursor-123'],
            ['cursor-'],
            ['cursor'],
            ['pointer-cursor'],
            ['cursor-[invalid'],
            // ['cursor-invalid]'],
        ];
    }

    #[DataProvider('edgeCaseProvider')]
    public function testEdgeCases(string $input, string $expected): void
    {
        $cursorClass = CursorClass::parse($input);
        $this->assertInstanceOf(CursorClass::class, $cursorClass);
        $this->assertSame($expected, $cursorClass->toCss());
    }

    public static function edgeCaseProvider(): array
    {
        return [
            ['cursor-[url(cursor.cur)]', '.cursor-\\[url\\(cursor\\.cur\\)\\]{cursor:url(cursor.cur);}'],
            ['cursor-[url(hand.cur),pointer]', '.cursor-\\[url\\(hand\\.cur\\)\\2c pointer\\]{cursor:url(hand.cur),pointer;}'],
            ['cursor-[url("cursor.png")]', '.cursor-\\[url\\(\\"cursor\\.png\\"\\)\\]{cursor:url("cursor.png");}'],
            ['cursor-[url(\'cursor.svg\')]', '.cursor-\\[url\\(\\\'cursor\\.svg\\\'\\)\\]{cursor:url(\'cursor.svg\');}'],
        ];
    }
}