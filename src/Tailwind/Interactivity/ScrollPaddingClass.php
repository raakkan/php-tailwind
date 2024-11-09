<?php

namespace Raakkan\PhpTailwind\Tailwind\Interactivity;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpacingValueCalculator;

class ScrollPaddingClass extends AbstractTailwindClass
{
    private $direction;

    private $isArbitrary;

    public function __construct(string $value, string $direction = '', bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->direction = $direction;
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $value = SpacingValueCalculator::calculate($this->value);
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : str_replace(['/', '.'], ['\/', '\.'], $this->value);

        switch ($this->direction) {
            case 'x':
                return ".scroll-px-{$classValue}{scroll-padding-left:{$value};scroll-padding-right:{$value};}";
            case 'y':
                return ".scroll-py-{$classValue}{scroll-padding-top:{$value};scroll-padding-bottom:{$value};}";
            case 't':
                return ".scroll-pt-{$classValue}{scroll-padding-top:{$value};}";
            case 'r':
                return ".scroll-pr-{$classValue}{scroll-padding-right:{$value};}";
            case 'b':
                return ".scroll-pb-{$classValue}{scroll-padding-bottom:{$value};}";
            case 'l':
                return ".scroll-pl-{$classValue}{scroll-padding-left:{$value};}";
            case 's':
                return ".scroll-ps-{$classValue}{scroll-padding-inline-start:{$value};}";
            case 'e':
                return ".scroll-pe-{$classValue}{scroll-padding-inline-end:{$value};}";
            default:
                return ".scroll-p-{$classValue}{scroll-padding:{$value};}";
        }
    }

    private function isValidValue(): bool
    {
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
        $pattern = '/^(-?\d*\.?\d+)('.implode('|', $validUnits).')?$/';

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
        if (preg_match('/^scroll-p(x|y|t|r|b|l|s|e)?-((?:\[.+\]|\d+\/\d+|.+))$/', $class, $matches)) {
            $direction = $matches[1] ?? '';
            $value = $matches[2];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            return new self($value, $direction, $isArbitrary);
        }

        return null;
    }
}
