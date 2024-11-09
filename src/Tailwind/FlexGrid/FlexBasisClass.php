<?php

namespace Raakkan\PhpTailwind\Tailwind\FlexGrid;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;

class FlexBasisClass extends AbstractTailwindClass
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

        $classValue = $this->value;

        if ($this->isArbitrary) {
            $escapedClassValue = '\['.$this->escapeArbitraryValue($classValue).'\]';
        } else {
            $escapedClassValue = preg_replace('/[\/\.]/', '\\\\$0', $classValue);
        }

        $cssValue = $this->calculateValue();

        return ".basis-{$escapedClassValue}{flex-basis:{$cssValue};}";
    }

    private function isValidValue(): bool
    {
        $validValues = ['0', 'px', '0.5', '1', '1.5', '2', '2.5', '3', '3.5', '4', '5', '6', '7', '8', '9', '10', '11', '12', '14', '16', '20', '24', '28', '32', '36', '40', '44', '48', '52', '56', '60', '64', '72', '80', '96', 'auto', 'full'];

        if (in_array($this->value, $validValues)) {
            return true;
        }

        if ($this->isValidFraction($this->value)) {
            return true;
        }

        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue($this->value);
        }

        return false;
    }

    private function isValidFraction($value): bool
    {
        $validFractions = ['1/2', '1/3', '2/3', '1/4', '2/4', '3/4', '1/5', '2/5', '3/5', '4/5', '1/6', '2/6', '3/6', '4/6', '5/6', '1/12', '2/12', '3/12', '4/12', '5/12', '6/12', '7/12', '8/12', '9/12', '10/12', '11/12'];

        return in_array($value, $validFractions);
    }

    private function calculateValue(): string
    {
        if ($this->value === 'auto') {
            return 'auto';
        }

        if ($this->value === 'full') {
            return '100%';
        }

        if (preg_match('/^(\d+)\/(\d+)$/', $this->value, $matches)) {
            $numerator = intval($matches[1]);
            $denominator = intval($matches[2]);

            return round(($numerator / $denominator * 100), 6).'%';
        }

        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return SpacingValueCalculator::calculate($this->value);
    }

    private function isValidArbitraryValue($value): bool
    {
        $value = trim($value, '[]');
        $validUnits = ['px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax'];
        $pattern = '/^(-?\d*\.?\d+)('.implode('|', $validUnits).')$/';

        if (preg_match($pattern, $value)) {
            return true;
        }

        if (strpos($value, 'calc(') === 0 && substr($value, -1) === ')') {
            // More thorough check for calc() expressions
            $content = substr($value, 5, -1);
            if (strlen($content) > 0 && $this->hasBalancedParentheses($content)) {
                return $this->isValidCalcExpression($content);
            }
        }

        return false;
    }

    private function hasBalancedParentheses($str): bool
    {
        $count = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] === '(') {
                $count++;
            }
            if ($str[$i] === ')') {
                $count--;
            }
            if ($count < 0) {
                return false;
            }
        }

        return $count === 0;
    }

    private function isValidCalcExpression($expr): bool
    {
        // This is a basic check and might need to be expanded based on your needs
        return preg_match('/^[\d\s\+\-\*\/\(\)\%]+$/', $expr) && ! preg_match('/[\+\-\*\/]{2,}/', $expr) && ! preg_match('/\s-\s$/', $expr);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^basis-(.+)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            return new self($value, $isArbitrary);
        }

        return null;
    }
}
