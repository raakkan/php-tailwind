<?php

namespace Raakkan\PhpTailwind\Tailwind\Sizing;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;

class MaxHeightClass extends AbstractTailwindClass
{
    private $isArbitrary;

    public function __construct(string $value, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : str_replace('.', '\\.', $this->value);
        $maxHeightValue = $this->getMaxHeightValue();

        return ".max-h-{$classValue}{max-height:{$maxHeightValue};}";
    }

    private function getMaxHeightValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->calculateMaxHeight($this->value);
    }

    private function calculateMaxHeight(string $value): string
    {
        $maxHeights = $this->getMaxHeights();

        if (isset($maxHeights[$value])) {
            return $maxHeights[$value];
        }

        return SpacingValueCalculator::calculate($value);
    }

    private function getMaxHeights(): array
    {
        return [
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
            'none' => 'none',
            'full' => '100%',
            'screen' => '100vh',
            'svh' => '100svh',
            'lvh' => '100lvh',
            'dvh' => '100dvh',
            'min' => 'min-content',
            'max' => 'max-content',
            'fit' => 'fit-content',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_merge(
            array_keys($this->getMaxHeights()),
            array_keys(SpacingValueCalculator::$spacingScale)
        );

        return in_array($this->value, $validValues) || is_numeric($this->value);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Check for valid CSS length units or percentage
        $validUnits = ['px', 'em', 'rem', '%', 'vh', 'svh', 'lvh', 'dvh', 'vmin', 'vmax', 'ex', 'ch', 'cm', 'mm', 'in', 'pt', 'pc'];
        $pattern = '/^(-?\d*\.?\d+)(' . implode('|', $validUnits) . ')$/';

        if (preg_match($pattern, $value)) {
            return true;
        }

        // Check for calc(), clamp(), min(), or max() expressions
        if (preg_match('/^(calc|clamp|min|max)\(.*\)$/', $value)) {
            // Additional check for non-empty content inside parentheses
            return preg_match('/^(calc|clamp|min|max)\([^()]+\)$/', $value);
        }

        return false;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^max-h-((?:\[.+\]|\d+\/\d+|.+))$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            
            return new self($value, $isArbitrary);
        }
        return null;
    }

    // protected function escapeArbitraryValue(string $value): string
    // {
    //     // Remove square brackets
    //     $value = trim($value, '[]');
        
    //     // Escape special characters, but keep commas unescaped
    //     $value = preg_replace('/([^a-zA-Z0-9,._-])/', '\\\\$1', $value);
        
    //     return $value;
    // }
}