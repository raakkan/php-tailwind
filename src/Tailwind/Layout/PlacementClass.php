<?php

namespace Raakkan\PhpTailwind\Tailwind\Layout;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;

class PlacementClass extends AbstractTailwindClass
{
    private $property;
    private $isNegative;
    private $isArbitrary;
    private $isXy;

    public function __construct(string $value, string $property, bool $isNegative = false, bool $isArbitrary = false, bool $isXy = false)
    {
        parent::__construct($value);
        $this->property = $property;
        $this->isNegative = $isNegative;
        $this->isArbitrary = $isArbitrary;
        $this->isXy = $isXy;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {   
            return '';
        }
        
        $prefix = $this->isNegative ? '-' : '';
        $classValue = $this->value;
        $propertyName = $this->property;

        if ($this->isXy) {
            if (preg_match('/^(x|y)-(.+)$/', $classValue, $matches)) {
                $propertyName .= '-' . $matches[1];
                $classValue = $matches[2];
            }
        }

        if ($this->isArbitrary) {
            $classValue = '\[' . $this->escapeArbitraryValue($classValue) . '\]';
            $escapedClassValue = $classValue;
        } else {
            $classValue = str_replace('/', '\/', $classValue);
            $escapedClassValue = preg_replace('/\./', '\\.', $classValue);
        }

        $cssProperties = $this->getCssProperties();
        
        $css = ".{$prefix}{$propertyName}-{$escapedClassValue}{";
        foreach ($cssProperties as $prop => $val) {
            $css .= "{$prop}:{$val};";
        }
        $css .= "}";
        
        return $css;
    }

    private function getCssProperties(): array
    {
        $value = $this->calculateValue();
        switch ($this->property) {
            case 'inset':
                if (strpos($this->value, 'x-') === 0) {
                    return ['left' => $value, 'right' => $value];
                } elseif (strpos($this->value, 'y-') === 0) {
                    return ['top' => $value, 'bottom' => $value];
                } else {
                    return ['inset' => $value];
                }
            case 'start':
                return ['inset-inline-start' => $value];
            case 'end':
                return ['inset-inline-end' => $value];
            default:
                return [$this->property => $value];
        }
    }

    private function isValidValue(): bool
    {
        $validValues = ['0', 'px', '0.5', '1', '1.5', '2', '2.5', '3', '3.5', '4', '5', '6', '7', '8', '9', '10', '11', '12', '14', '16', '20', '24', '28', '32', '36', '40', '44', '48', '52', '56', '60', '64', '72', '80', '96', 'auto', 'full'];
        
        $actualValue = $this->value;
        if ($this->property === 'inset' && preg_match('/^(x|y)-(.+)$/', $this->value, $matches)) {
            $actualValue = $matches[2];
        }

        if (in_array($actualValue, $validValues)) {
            return true;
        }

        if ($this->isValidFraction($actualValue)) {
            return true;
        }

        // Check for valid arbitrary values
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue($actualValue);
        }
        
        return false;
    }

    private function isValidFraction($value): bool
    {
        if (preg_match('/^(\d+)\/(\d+)$/', $value, $matches)) {
            $numerator = intval($matches[1]);
            $denominator = intval($matches[2]);
            
            $validFractions = ['1/2', '1/3', '2/3', '1/4', '2/4', '3/4'];
            return in_array($value, $validFractions);
        }
        return false;
    }

    private function calculateValue(): string
    {
        $actualValue = $this->value;
        if ($this->property === 'inset' && preg_match('/^(x|y)-(.+)$/', $this->value, $matches)) {
            $actualValue = $matches[2];
        }

        if ($actualValue === 'auto') {
            return 'auto';
        }

        if ($actualValue === 'full') {
            return '100%';
        }

        if (preg_match('/^(\d+)\/(\d+)$/', $actualValue, $matches)) {
            $numerator = intval($matches[1]);
            $denominator = intval($matches[2]);
            $percentage = round(($numerator / $denominator * 100), 6);
            return ($this->isNegative ? '-' : '') . $percentage . '%';
        }

        if ($this->isArbitrary) {
            $value = trim($actualValue, '[]');
            return ($this->isNegative ? '-' : '') . $value;
        }

        return SpacingValueCalculator::calculate($actualValue, $this->isNegative);
    }

    private function isValidArbitraryValue($value): bool
    {
        // Remove square brackets if present
        $value = trim($value, '[]');

        // Check for valid CSS length units
        $validUnits = ['px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax', 'ex', 'ch', 'cm', 'mm', 'in', 'pt', 'pc'];
        $pattern = '/^(-?\d*\.?\d+)(' . implode('|', $validUnits) . ')$/';
        
        if (preg_match($pattern, $value)) {
            return true;
        }

        // Check for calc() expressions
        if (strpos($value, 'calc(') === 0 && substr($value, -1) === ')') {
            return true;
        }
        
        return false;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(-?)(inset|top|right|bottom|left|start|end)-(.+)$/', $class, $matches)) {
            [, $negative, $property, $value] = $matches;
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            $isXy = false;

            if ($property === 'inset' && preg_match('/^(x|y)-(.+)$/', $value, $matches)) {
                $isArbitrary = preg_match('/^\[.+\]$/', $matches[2]);
                $isXy = true;
            }
            
            return new self($value, $property, $negative === '-', $isArbitrary, $isXy);
        }
        return null;
    }
}