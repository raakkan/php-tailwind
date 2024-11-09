<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Layout\PlacementClass;

class PlacementTest extends TestCase
{
    #[DataProvider('placementClassProvider')]
    public function testPlacementClass(string $input, string $expected): void
    {
        $placementClass = PlacementClass::parse($input);
        $this->assertInstanceOf(PlacementClass::class, $placementClass);
        $this->assertSame($expected, $placementClass->toCss());
    }

    public static function placementClassProvider(): array
    {
        return [
            // Standard values
            ['inset-0', '.inset-0{inset:0px;}'],
            ['inset-px', '.inset-px{inset:1px;}'],
            ['inset-1', '.inset-1{inset:0.25rem;}'],
            ['inset-4', '.inset-4{inset:1rem;}'],
            ['inset-96', '.inset-96{inset:24rem;}'],
            ['inset-1/2', '.inset-1\/2{inset:50%;}'],
            ['inset-1/3', '.inset-1\/3{inset:33.333333%;}'],
            ['inset-2/3', '.inset-2\/3{inset:66.666667%;}'],
            ['inset-1/4', '.inset-1\/4{inset:25%;}'],
            ['inset-3/4', '.inset-3\/4{inset:75%;}'],
            ['inset-0.5', '.inset-0\.5{inset:0.125rem;}'],
            ['inset-y-0.5', '.inset-y-0\.5{top:0.125rem;bottom:0.125rem;}'],
            ['bottom-1/2', '.bottom-1\/2{bottom:50%;}'],
            ['left-1/2', '.left-1\/2{left:50%;}'],
            ['top-1/2', '.top-1\/2{top:50%;}'],
            ['right-1/2', '.right-1\/2{right:50%;}'],
            ['top-1.5', '.top-1\.5{top:0.375rem;}'],

            // Fractional values
            ['inset-1/2', '.inset-1\/2{inset:50%;}'],
            ['inset-1/3', '.inset-1\/3{inset:33.333333%;}'],
            ['inset-2/3', '.inset-2\/3{inset:66.666667%;}'],
            ['inset-1/4', '.inset-1\/4{inset:25%;}'],
            ['inset-3/4', '.inset-3\/4{inset:75%;}'],

            // Special values
            ['inset-auto', '.inset-auto{inset:auto;}'],
            ['inset-full', '.inset-full{inset:100%;}'],

            // Negative values
            ['-inset-1', '.-inset-1{inset:-0.25rem;}'],
            ['-inset-4', '.-inset-4{inset:-1rem;}'],
            ['-inset-px', '.-inset-px{inset:-1px;}'],
            ['-inset-1/2', '.-inset-1\/2{inset:-50%;}'],

            // Arbitrary values
            ['inset-[10px]', '.inset-\[10px\]{inset:10px;}'],
            ['inset-[2rem]', '.inset-\[2rem\]{inset:2rem;}'],
            ['inset-[5vh]', '.inset-\[5vh\]{inset:5vh;}'],
            ['inset-[calc(100%-20px)]', '.inset-\[calc\(100\%-20px\)\]{inset:calc(100%-20px);}'],

            // Different properties
            ['top-0', '.top-0{top:0px;}'],
            ['right-4', '.right-4{right:1rem;}'],
            ['bottom-1/2', '.bottom-1\/2{bottom:50%;}'],
            ['left-full', '.left-full{left:100%;}'],
            ['start-3', '.start-3{inset-inline-start:0.75rem;}'],
            ['end-auto', '.end-auto{inset-inline-end:auto;}'],

            // inset-x and inset-y
            ['inset-x-0', '.inset-x-0{left:0px;right:0px;}'],
            ['inset-y-4', '.inset-y-4{top:1rem;bottom:1rem;}'],
            ['-inset-x-1/2', '.-inset-x-1\/2{left:-50%;right:-50%;}'],
            ['inset-y-[10px]', '.inset-y-\[10px\]{top:10px;bottom:10px;}'],

            // Arbitrary values
            ['top-[3px]', '.top-\[3px\]{top:3px;}'],
            ['right-[300px]', '.right-\[300px\]{right:300px;}'],
            ['bottom-[-300px]', '.bottom-\[-300px\]{bottom:-300px;}'],
            ['left-[23rem]', '.left-\[23rem\]{left:23rem;}'],
            ['inset-[7px]', '.inset-\[7px\]{inset:7px;}'],
            ['inset-[0.5rem]', '.inset-\[0\.5rem\]{inset:0.5rem;}'],
            ['inset-x-[5%]', '.inset-x-\[5\%\]{left:5%;right:5%;}'],
            ['inset-y-[6vh]', '.inset-y-\[6vh\]{top:6vh;bottom:6vh;}'],

            // Arbitrary values with calc()
            ['top-[calc(100%-1rem)]', '.top-\[calc\(100\%-1rem\)\]{top:calc(100%-1rem);}'],
            ['inset-[calc(1rem+10px)]', '.inset-\[calc\(1rem\+10px\)\]{inset:calc(1rem+10px);}'],

            // Negative arbitrary values
            ['-left-[3px]', '.-left-\[3px\]{left:-3px;}'],
            ['-inset-[10px]', '.-inset-\[10px\]{inset:-10px;}'],
            ['-inset-x-[10px]', '.-inset-x-\[10px\]{left:-10px;right:-10px;}'],

            // Start and end properties
            ['start-[5px]', '.start-\[5px\]{inset-inline-start:5px;}'],
            ['end-[10rem]', '.end-\[10rem\]{inset-inline-end:10rem;}'],

            // Invalid arbitrary values (should return empty string)
            ['top-[invalid]', ''],
            ['inset-[not-a-value]', ''],
        ];
    }

    public function testInvalidPlacementClass(): void
    {
        $this->assertNull(PlacementClass::parse('invalid-class'));
    }

    public function testPlacementClassWithInvalidValue(): void
    {
        $placementClass = PlacementClass::parse('inset-invalid');
        $this->assertInstanceOf(PlacementClass::class, $placementClass);
        $this->assertSame('', $placementClass->toCss());
    }
}
