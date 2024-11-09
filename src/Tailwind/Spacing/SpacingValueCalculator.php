<?php

namespace Raakkan\PhpTailwind\Tailwind\Spacing;

class SpacingValueCalculator
{
    public static $spacingScale = [
        '0' => '0px',
        'px' => '1px',
        '0.5' => '0.125rem',
        '1' => '0.25rem',
        '1.5' => '0.375rem',
        '2' => '0.5rem',
        '2.5' => '0.625rem',
        '3' => '0.75rem',
        '3.5' => '0.875rem',
        '4' => '1rem',
        '5' => '1.25rem',
        '6' => '1.5rem',
        '7' => '1.75rem',
        '8' => '2rem',
        '9' => '2.25rem',
        '10' => '2.5rem',
        '11' => '2.75rem',
        '12' => '3rem',
        '14' => '3.5rem',
        '16' => '4rem',
        '20' => '5rem',
        '24' => '6rem',
        '28' => '7rem',
        '32' => '8rem',
        '36' => '9rem',
        '40' => '10rem',
        '44' => '11rem',
        '48' => '12rem',
        '52' => '13rem',
        '56' => '14rem',
        '60' => '15rem',
        '64' => '16rem',
        '72' => '18rem',
        '80' => '20rem',
        '96' => '24rem',
    ];

    public static function calculate($value, $isNegative = false)
    {
        // Handle special cases
        if (isset(self::$spacingScale[$value])) {
            $calculatedValue = self::$spacingScale[$value];
        }
        // Handle fractions
        elseif (strpos($value, '/') !== false) {
            [$numerator, $denominator] = explode('/', $value);
            $percentage = (floatval($numerator) / floatval($denominator)) * 100;
            $calculatedValue = round($percentage, 6).'%';
        }
        // Handle arbitrary values
        elseif (preg_match('/^\[(.+)\]$/', $value, $matches)) {
            $calculatedValue = $matches[1];
            // If it's a number without a unit, assume pixels
            if (is_numeric($calculatedValue)) {
                $calculatedValue .= 'px';
            }
        }
        // Handle numeric values (using Tailwind's 0.25rem scale)
        elseif (is_numeric($value)) {
            $calculatedValue = (floatval($value) * 0.25).'rem';
        } else {
            // If we can't calculate, return the original value
            $calculatedValue = $value;
        }

        return $isNegative ? "-$calculatedValue" : $calculatedValue;
    }
}
