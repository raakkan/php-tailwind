<?php

namespace Raakkan\PhpTailwind\Tailwind\Sizing;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;

class MaxWidthClass extends AbstractTailwindClass
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
        $maxWidthValue = $this->getMaxWidthValue();

        return ".max-w-{$classValue}{max-width:{$maxWidthValue};}";
    }

    private function getMaxWidthValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->calculateMaxWidth($this->value);
    }

    private function calculateMaxWidth(string $value): string
    {
        $maxWidths = $this->getMaxWidths();

        if (isset($maxWidths[$value])) {
            return $maxWidths[$value];
        }

        return SpacingValueCalculator::calculate($value);
    }

    private function getMaxWidths(): array
    {
        return [
            '0' => '0px',
            'none' => 'none',
            'xs' => '20rem',
            'sm' => '24rem',
            'md' => '28rem',
            'lg' => '32rem',
            'xl' => '36rem',
            '2xl' => '42rem',
            '3xl' => '48rem',
            '4xl' => '56rem',
            '5xl' => '64rem',
            '6xl' => '72rem',
            '7xl' => '80rem',
            'full' => '100%',
            'min' => 'min-content',
            'max' => 'max-content',
            'fit' => 'fit-content',
            'prose' => '65ch',
            'screen-sm' => '640px',
            'screen-md' => '768px',
            'screen-lg' => '1024px',
            'screen-xl' => '1280px',
            'screen-2xl' => '1536px',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_merge(
            array_keys($this->getMaxWidths()),
            array_keys(SpacingValueCalculator::$spacingScale)
        );

        return in_array($this->value, $validValues) || is_numeric($this->value);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Check for valid CSS length units or percentage
        $validUnits = ['px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax', 'ex', 'ch', 'cm', 'mm', 'in', 'pt', 'pc'];
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
        if (preg_match('/^max-w-((?:\[.+\]|\d+\/\d+|.+))$/', $class, $matches)) {
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
