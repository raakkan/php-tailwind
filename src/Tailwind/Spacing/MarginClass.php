<?php

namespace Raakkan\PhpTailwind\Tailwind\Spacing;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class MarginClass extends AbstractTailwindClass
{
    private $direction;
    private $isNegative;
    private $isAuto;
    private $isArbitrary;

    public function __construct(string $value, string $direction = '', bool $isNegative = false, bool $isAuto = false, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->direction = $direction;
        $this->isNegative = $isNegative;
        $this->isAuto = $isAuto;
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        if ($this->isAuto) {
            return $this->getAutoMargin();
        }

        $value = SpacingValueCalculator::calculate($this->value, $this->isNegative);
        
        $prefix = $this->isNegative ? '-' : '';
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : str_replace(['/', '.'], ['\/', '\.'], $this->value);
        
        switch ($this->direction) {
            case 'x':
                return ".{$prefix}mx-{$classValue}{margin-left:{$value};margin-right:{$value};}";
            case 'y':
                return ".{$prefix}my-{$classValue}{margin-top:{$value};margin-bottom:{$value};}";
            case 't':
                return ".{$prefix}mt-{$classValue}{margin-top:{$value};}";
            case 'r':
                return ".{$prefix}mr-{$classValue}{margin-right:{$value};}";
            case 'b':
                return ".{$prefix}mb-{$classValue}{margin-bottom:{$value};}";
            case 'l':
                return ".{$prefix}ml-{$classValue}{margin-left:{$value};}";
            case 'e':
                return ".{$prefix}me-{$classValue}{margin-inline-end:{$value};}";
            case 's':
                return ".{$prefix}ms-{$classValue}{margin-inline-start:{$value};}";
            default:
                return ".{$prefix}m-{$classValue}{margin:{$value};}";
        }
    }

    private function getAutoMargin(): string
    {
        switch ($this->direction) {
            case 'x':
                return ".mx-auto{margin-left:auto;margin-right:auto;}";
            case 'y':
                return ".my-auto{margin-top:auto;margin-bottom:auto;}";
            case 't':
                return ".mt-auto{margin-top:auto;}";
            case 'r':
                return ".mr-auto{margin-right:auto;}";
            case 'b':
                return ".mb-auto{margin-bottom:auto;}";
            case 'l':
                return ".ml-auto{margin-left:auto;}";
            case 'e':
                return ".me-auto{margin-inline-end:auto;}";
            case 's':
                return ".ms-auto{margin-inline-start:auto;}";
            default:
                return ".m-auto{margin:auto;}";
        }
    }

    private function isValidValue(): bool
    {
        if ($this->isAuto) {
            return true; // 'auto' is a valid value for margin
        }

        $validValues = ['0', 'px', '0.5', '1', '1.5', '2', '2.5', '3', '3.5', '4', '5', '6', '7', '8', '9', '10', '11', '12', '14', '16', '20', '24', '28', '32', '36', '40', '44', '48', '52', '56', '60', '64', '72', '80', '96'];

        if (in_array($this->value, $validValues)) {
            return true;
        }

        // Check for valid fractional values
        if (preg_match('/^(\d+)\/(\d+)$/', $this->value, $matches)) {
            $numerator = intval($matches[1]);
            $denominator = intval($matches[2]);
            
            return $denominator !== 0; // Allow any fraction as long as denominator is not zero
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

        // Check for calc() expressions
        if (strpos($value, 'calc(') === 0 && substr($value, -1) === ')') {
            // Basic check for calc() - you might want to add more sophisticated validation
            return true;
        }

        return false;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(-?)(m)(x|y|t|r|b|l|e|s)?-((?:\[.+\]|\d+\/\d+|.+))$/', $class, $matches)) {
            [, $negative, , $direction, $value] = $matches;
            $isAuto = $value === 'auto';
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            
            return new self($value, $direction ?: '', $negative === '-', $isAuto, $isArbitrary);
        }
        return null;
    }
}