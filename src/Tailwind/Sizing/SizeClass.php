<?php

namespace Raakkan\PhpTailwind\Tailwind\Sizing;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;

class SizeClass extends AbstractTailwindClass
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

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : str_replace(['.', '/'], ['\\.', '\\/'], $this->value);
        $sizeValue = $this->getSizeValue();

        return ".size-{$classValue}{width:{$sizeValue};height:{$sizeValue};}";
    }

    private function getSizeValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->calculateSize($this->value);
    }

    private function calculateSize(string $value): string
    {
        $sizes = $this->getSizes();

        if (isset($sizes[$value])) {
            return $sizes[$value];
        }

        // Handle fractional values
        if (preg_match('/^(\d+)\/(\d+)$/', $value, $matches)) {
            $numerator = (int)$matches[1];
            $denominator = (int)$matches[2];
            $percentage = ($numerator / $denominator) * 100;

            // Use more precise percentages for specific fractions
            if (in_array($value, ['1/3', '2/3', '1/6', '2/6', '4/6', '5/6'])) {
                return number_format($percentage, 6, '.', '') . '%';
            }

            return round($percentage) . '%';
        }

        return SpacingValueCalculator::calculate($value);
    }

    private function getSizes(): array
    {
        return [
            'auto' => 'auto',
            'px' => '1px',
            'full' => '100%',
            'screen' => '100vw',
            'svw' => '100svw',
            'lvw' => '100lvw',
            'dvw' => '100dvw',
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
            array_keys($this->getSizes()),
            array_keys(SpacingValueCalculator::$spacingScale)
        );

        // Add support for fractional values
        if (preg_match('/^\d+\/\d+$/', $this->value)) {
            return true;
        }

        return in_array($this->value, $validValues) || is_numeric($this->value);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Check for valid CSS length units or percentage
        $validUnits = ['px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax', 'ex', 'ch', 'cm', 'mm', 'in', 'pt', 'pc', 'svw', 'lvw', 'dvw'];
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
        if (preg_match('/^size-((?:\[.+\]|\d+\/\d+|.+))$/', $class, $matches)) {
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