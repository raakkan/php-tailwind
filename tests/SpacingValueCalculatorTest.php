<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;
use PHPUnit\Framework\Attributes\DataProvider;

class SpacingValueCalculatorTest extends TestCase
{
    #[DataProvider('spacingValueCalculatorProvider')]
    public function testSpacingValueCalculator(string $input, bool $isNegative, string $expected): void
    {
        $this->assertSame($expected, SpacingValueCalculator::calculate($input, $isNegative));
    }

    public static function spacingValueCalculatorProvider(): array
    {
        return [
            ['0', false, '0px'],
            ['px', false, '1px'],
            ['0.5', false, '0.125rem'],
            ['1', false, '0.25rem'],
            ['1.5', false, '0.375rem'],
            ['2', false, '0.5rem'],
            ['2.5', false, '0.625rem'],
            ['3', false, '0.75rem'],
            ['3.5', false, '0.875rem'],
            ['4', false, '1rem'],
            ['5', false, '1.25rem'],
            ['6', false, '1.5rem'],
            ['7', false, '1.75rem'],
            ['8', false, '2rem'],
            ['9', false, '2.25rem'],
            ['10', false, '2.5rem'],
            ['11', false, '2.75rem'],
            ['12', false, '3rem'],
            ['14', false, '3.5rem'],
            ['16', false, '4rem'],
            ['20', false, '5rem'],
            ['24', false, '6rem'],
            ['28', false, '7rem'],
            ['32', false, '8rem'],
            ['36', false, '9rem'],
            ['40', false, '10rem'],
            ['44', false, '11rem'],
            ['48', false, '12rem'],
            ['52', false, '13rem'],
            ['56', false, '14rem'],
            ['60', false, '15rem'],
            ['64', false, '16rem'],
            ['72', false, '18rem'],
            ['80', false, '20rem'],
            ['96', false, '24rem'],
            ['0', true, '-0px'],
            ['px', true, '-1px'],
            ['1', true, '-0.25rem'],
            ['2', true, '-0.5rem'],
            ['4', true, '-1rem'],
            ['8', true, '-2rem'],
            ['16', true, '-4rem'],
            ['32', true, '-8rem'],
            ['64', true, '-16rem'],
            ['[10px]', false, '10px'],
            ['[2em]', false, '2em'],
            ['[10vh]', false, '10vh'],
            ['[5%]', false, '5%'],
            ['[10px]', true, '-10px'],
            ['[2em]', true, '-2em'],
            ['[10vh]', true, '-10vh'],
            ['[5%]', true, '-5%'],
        ];
    }

    #[DataProvider('fractionSpacingValueProvider')]
    public function testFractionSpacingValue(string $input, bool $isNegative, string $expected): void
    {
        $this->assertSame($expected, SpacingValueCalculator::calculate($input, $isNegative));
    }

    public static function fractionSpacingValueProvider(): array
    {
        return [
            ['1/2', false, '50%'],
            ['1/3', false, '33.333333%'],
            ['2/3', false, '66.666667%'],
            ['1/4', false, '25%'],
            ['2/4', false, '50%'],
            ['3/4', false, '75%'],
            ['1/5', false, '20%'],
            ['2/5', false, '40%'],
            ['3/5', false, '60%'],
            ['4/5', false, '80%'],
            ['1/6', false, '16.666667%'],
            ['2/6', false, '33.333333%'],
            ['3/6', false, '50%'],
            ['4/6', false, '66.666667%'],
            ['5/6', false, '83.333333%'],
            ['1/12', false, '8.333333%'],
            ['2/12', false, '16.666667%'],
            ['3/12', false, '25%'],
            ['4/12', false, '33.333333%'],
            ['5/12', false, '41.666667%'],
            ['6/12', false, '50%'],
            ['7/12', false, '58.333333%'],
            ['8/12', false, '66.666667%'],
            ['9/12', false, '75%'],
            ['10/12', false, '83.333333%'],
            ['11/12', false, '91.666667%'],
            ['1/2', true, '-50%'],
            ['1/3', true, '-33.333333%'],
            ['2/3', true, '-66.666667%'],
            ['1/4', true, '-25%'],
            ['3/4', true, '-75%'],
        ];
    }
}