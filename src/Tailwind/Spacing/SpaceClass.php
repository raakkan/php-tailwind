<?php

namespace Raakkan\PhpTailwind\Tailwind\Spacing;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class SpaceClass extends AbstractTailwindClass
{
    private $direction;
    private $isReverse;
    private $isArbitrary;
    private $isNegative;

    public function __construct(string $value, string $direction, bool $isReverse = false, bool $isArbitrary = false, bool $isNegative = false)
    {
        parent::__construct($value);
        $this->direction = $direction;
        $this->isReverse = $isReverse;
        $this->isArbitrary = $isArbitrary;
        $this->isNegative = $isNegative;
    }

    public function toCss(): string
    {
        if ($this->isReverse) {
            return ".space-{$this->direction}-reverse>:not([hidden])~:not([hidden]){--tw-space-{$this->direction}-reverse:1;}";
        }

        if (!$this->isValidValue()) {
            return '';
        }

        $value = $this->calculateValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;

        return $this->generateSpaceCss($classValue, $value);
    }

    private function generateSpaceCss(string $classValue, string $value): string
    {
        $prefix = $this->isNegative ? '-' : '';
        $value = $this->isArbitrary && $this->isNegative ? '-' . $value : $value;
        $property1 = $this->direction === 'x' ? 'margin-right' : 'margin-top';
        $property2 = $this->direction === 'x' ? 'margin-left' : 'margin-bottom';

        $calc1 = $this->direction === 'x' ? "calc({$value} * var(--tw-space-{$this->direction}-reverse))" : "calc({$value} * calc(1 - var(--tw-space-{$this->direction}-reverse)))";
        $calc2 = $this->direction === 'x' ? "calc({$value} * calc(1 - var(--tw-space-{$this->direction}-reverse)))" : "calc({$value} * var(--tw-space-{$this->direction}-reverse))";

        return ".{$prefix}space-{$this->direction}-{$classValue}>:not([hidden])~:not([hidden]){" .
               "--tw-space-{$this->direction}-reverse:0;" .
               "{$property1}:{$calc1};" .
               "{$property2}:{$calc2};}";
    }

    private function calculateValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return SpacingValueCalculator::calculate($this->value, $this->isNegative);
    }

    private function isValidValue(): bool
    {
        $validValues = ['0', 'px', '0.5', '1', '1.5', '2', '2.5', '3', '3.5', '4', '5', '6', '7', '8', '9', '10', '11', '12', '14', '16', '20', '24', '28', '32', '36', '40', '44', '48', '52', '56', '60', '64', '72', '80', '96'];

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

        // Check for calc() expressions
        if (strpos($value, 'calc(') === 0 && substr($value, -1) === ')') {
            // Basic check for calc() - you might want to add more sophisticated validation
            return true;
        }
        return false;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(-)?space-(x|y)(-reverse)?(-(\[.+\]|.+))?$/', $class, $matches)) {
            $isNegative = isset($matches[1]) && $matches[1] === '-';
            $direction = $matches[2];
            $isReverse = isset($matches[3]) && $matches[3] === '-reverse';
            $value = $isReverse ? '0' : ($matches[5] ?? '0');
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }
            
            return new self($value, $direction, $isReverse, $isArbitrary, $isNegative);
        }
        return null;
    }
}