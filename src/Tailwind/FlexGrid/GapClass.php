<?php

namespace Raakkan\PhpTailwind\Tailwind\FlexGrid;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;

class GapClass extends AbstractTailwindClass
{
    private $isArbitrary;

    private $axis;

    public function __construct(string $value, string $axis = '', bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
        $this->axis = $axis;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $classValue = $this->value;

        if ($this->isArbitrary) {
            $escapedClassValue = '\['.str_replace('/', '\/', $this->escapeArbitraryValue($classValue).'\]');
        } else {
            $escapedClassValue = preg_replace('/[\/\.]/', '\\\\$0', $classValue);
        }

        $cssValue = $this->calculateValue();

        $property = $this->getProperty();

        return ".gap{$this->axis}-{$escapedClassValue}{{$property}:{$cssValue};}";
    }

    private function isValidValue(): bool
    {
        $validValues = ['0', 'px', '0.5', '1', '1.5', '2', '2.5', '3', '3.5', '4', '5', '6', '7', '8', '9', '10', '11', '12', '14', '16', '20', '24', '28', '32', '36', '40', '44', '48', '52', '56', '60', '64', '72', '80', '96'];

        if (in_array($this->value, $validValues)) {
            return true;
        }

        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue($this->value);
        }

        return false;
    }

    private function calculateValue(): string
    {
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

        // Improved calc() validation
        if (strpos($value, 'calc(') === 0 && substr($value, -1) === ')') {
            $content = substr($value, 5, -1);

            return $this->isValidCalcExpression($content);
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
        // Remove spaces around operators
        $expr = preg_replace('/\s*([\+\-\*\/])\s*/', '$1', $expr);

        // Check for valid calc expression
        $validCalcPattern = '/^([\d\.]+[a-z%]*|\([^()]+\))(\s*[\+\-\*\/]\s*([\d\.]+[a-z%]*|\([^()]+\)))*$/';

        return preg_match($validCalcPattern, $expr);
    }

    private function getProperty(): string
    {
        switch ($this->axis) {
            case '-x':
                return 'column-gap';
            case '-y':
                return 'row-gap';
            default:
                return 'gap';
        }
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^gap(-[xy])?-(.+)$/', $class, $matches)) {
            $axis = $matches[1] ?? '';
            $value = $matches[2];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            return new self($value, $axis, $isArbitrary);
        }

        return null;
    }
}
