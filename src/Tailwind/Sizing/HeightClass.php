<?php

namespace Raakkan\PhpTailwind\Tailwind\Sizing;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;

class HeightClass extends AbstractTailwindClass
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
        $heightValue = $this->getHeightValue();

        return ".h-{$classValue}{height:{$heightValue};}";
    }

    private function getHeightValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->calculateHeight($this->value);
    }

    private function calculateHeight(string $value): string
    {
        $percentageHeights = $this->getPercentageHeights();
        $specialHeights = $this->getSpecialHeights();

        if (isset($percentageHeights[$value])) {
            return $percentageHeights[$value];
        }

        if (isset($specialHeights[$value])) {
            return $specialHeights[$value];
        }

        return SpacingValueCalculator::calculate($value);
    }

    private function getPercentageHeights(): array
    {
        return [
            'auto' => 'auto',
            '1/2' => '50%',
            '1/3' => '33.333333%',
            '2/3' => '66.666667%',
            '1/4' => '25%',
            '2/4' => '50%',
            '3/4' => '75%',
            '1/5' => '20%',
            '2/5' => '40%',
            '3/5' => '60%',
            '4/5' => '80%',
            '1/6' => '16.666667%',
            '2/6' => '33.333333%',
            '3/6' => '50%',
            '4/6' => '66.666667%',
            '5/6' => '83.333333%',
            'full' => '100%',
        ];
    }

    private function getSpecialHeights(): array
    {
        return [
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
            array_keys($this->getPercentageHeights()),
            array_keys($this->getSpecialHeights()),
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
        if (preg_match('/^h-((?:\[.+\]|\d+\/\d+|.+))$/', $class, $matches)) {
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