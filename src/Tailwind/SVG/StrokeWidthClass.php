<?php

namespace Raakkan\PhpTailwind\Tailwind\SVG;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class StrokeWidthClass extends AbstractTailwindClass
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

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $cssValue = $this->isArbitrary ? $this->value : $this->value;

        return ".stroke-{$classValue}{stroke-width:{$cssValue};}";
    }

    private function isValidValue(): bool
    {
        $validValues = ['0', '1', '2'];

        if (in_array($this->value, $validValues)) {
            return true;
        }

        // Check for valid arbitrary values
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        return false;
    }

    private function isValidArbitraryValue(): bool
    {
        // Remove square brackets
        $value = trim($this->value, '[]');

        // Check for valid CSS length units
        $validUnits = ['px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax', 'ex', 'ch', 'cm', 'mm', 'in', 'pt', 'pc'];
        $pattern = '/^(-?\d*\.?\d+)(' . implode('|', $validUnits) . ')?$/';

        if (preg_match($pattern, $value)) {
            return true;
        }

        // Check for unitless numbers
        if (is_numeric($value)) {
            return true;
        }

        // Check for calc() expressions
        if (preg_match('/^calc\(.+\)$/', $value)) {
            return true;
        }

        return false;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^stroke-(\[.+\]|\d+)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }
            
            return new self($value, $isArbitrary);
        }
        return null;
    }

    // private function escapeArbitraryValue(string $value): string
    // {
    //     return preg_replace('/([%+()])/i', '\\\\$1', $value);
    // }
}