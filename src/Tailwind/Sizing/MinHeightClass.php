<?php

namespace Raakkan\PhpTailwind\Tailwind\Sizing;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;

class MinHeightClass extends AbstractTailwindClass
{
    private $isArbitrary;

    public function __construct(string $value, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : str_replace('.', '\\.', $this->value);
        $minHeightValue = $this->getMinHeightValue();

        return ".min-h-{$classValue}{min-height:{$minHeightValue};}";
    }

    private function getMinHeightValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->calculateMinHeight($this->value);
    }

    private function calculateMinHeight(string $value): string
    {
        $minHeights = $this->getMinHeights();

        if (isset($minHeights[$value])) {
            return $minHeights[$value];
        }

        return SpacingValueCalculator::calculate($value);
    }

    private function getMinHeights(): array
    {
        return [
            '0' => '0px',
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
            array_keys($this->getMinHeights()),
            array_keys(SpacingValueCalculator::$spacingScale)
        );

        return in_array($this->value, $validValues) || is_numeric($this->value);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Check for valid CSS length units or percentage
        $validUnits = ['px', 'em', 'rem', '%', 'vh', 'vw', 'vmin', 'vmax', 'ex', 'ch', 'cm', 'mm', 'in', 'pt', 'pc', 'svh', 'lvh', 'dvh'];
        $pattern = '/^(-?\d*\.?\d+)('.implode('|', $validUnits).')$/';

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
        if (preg_match('/^min-h-((?:\[.+\]|\d+\/\d+|.+))$/', $class, $matches)) {
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
