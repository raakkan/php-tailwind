<?php

namespace Raakkan\PhpTailwind\Tailwind\Sizing;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;

class WidthClass extends AbstractTailwindClass
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
        $widthValue = $this->getWidthValue();

        return ".w-{$classValue}{width:{$widthValue};}";
    }

    private function getWidthValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->calculateWidth($this->value);
    }

    private function calculateWidth(string $value): string
    {
        $percentageWidths = $this->getPercentageWidths();
        $specialWidths = $this->getSpecialWidths();

        if (isset($percentageWidths[$value])) {
            return $percentageWidths[$value];
        }

        if (isset($specialWidths[$value])) {
            return $specialWidths[$value];
        }

        return SpacingValueCalculator::calculate($value);
    }

    private function getPercentageWidths(): array
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
            '1/12' => '8.333333%',
            '2/12' => '16.666667%',
            '3/12' => '25%',
            '4/12' => '33.333333%',
            '5/12' => '41.666667%',
            '6/12' => '50%',
            '7/12' => '58.333333%',
            '8/12' => '66.666667%',
            '9/12' => '75%',
            '10/12' => '83.333333%',
            '11/12' => '91.666667%',
            'full' => '100%',
        ];
    }

    private function getSpecialWidths(): array
    {
        return [
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
            array_keys($this->getPercentageWidths()),
            array_keys($this->getSpecialWidths()),
            array_keys(SpacingValueCalculator::$spacingScale)
        );

        return in_array($this->value, $validValues) || is_numeric($this->value);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Check for valid CSS length units or percentage
        $validUnits = ['px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax', 'ex', 'ch', 'cm', 'mm', 'in', 'pt', 'pc'];
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
        if (preg_match('/^w-((?:\[.+\]|\d+\/\d+|.+))$/', $class, $matches)) {
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