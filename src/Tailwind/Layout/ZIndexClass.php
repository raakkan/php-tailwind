<?php

namespace Raakkan\PhpTailwind\Tailwind\Layout;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class ZIndexClass extends AbstractTailwindClass
{
    private $isNegative;

    private $isArbitrary;

    public function __construct(string $value, bool $isNegative = false, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isNegative = $isNegative;
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $prefix = $this->isNegative ? '-' : '';
        $property = 'z-index';
        $value = $this->calculateValue();

        if ($this->isArbitrary) {
            $escapedClassName = $this->escapeArbitraryValue($this->value);

            return ".{$prefix}z-\[{$escapedClassName}\]{{$property}:{$value};}";
        } else {
            return ".{$prefix}z-{$this->value}{{$property}:{$value};}";
        }
    }

    private function isValidValue(): bool
    {
        $validValues = ['0', '10', '20', '30', '40', '50', 'auto'];

        if (in_array($this->value, $validValues)) {
            return true;
        }

        // Check for valid arbitrary values
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue($this->value);
        }

        return false;
    }

    private function calculateValue(): string
    {
        if ($this->value === 'auto') {
            return 'auto';
        }

        if ($this->isArbitrary) {
            $value = trim($this->value, '[]');

            return ($this->isNegative ? '-' : '').$value;
        }

        return ($this->isNegative ? '-' : '').$this->value;
    }

    private function isValidArbitraryValue($value): bool
    {
        // Remove square brackets if present
        $value = trim($value, '[]');

        // Check if it's a valid integer, CSS variable, or CSS function
        return is_numeric($value) ||
               strpos($value, '--') === 0 ||
               preg_match('/^(var|calc|clamp|min|max)\s*\(.*\)$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(-?)z-(.+)$/', $class, $matches)) {
            [, $negative, $value] = $matches;
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            return new self($value, $negative === '-', $isArbitrary);
        }

        return null;
    }
}
