<?php

namespace Raakkan\PhpTailwind\Tailwind\TransitionAnimation;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class TransitionTimingFunctionClass extends AbstractTailwindClass
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

        $timingFunction = $this->getTimingFunction();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;

        return ".ease-{$classValue}{transition-timing-function:{$timingFunction};}";
    }

    private function getTimingFunction(): string
    {
        $timingFunctions = [
            'linear' => 'linear',
            'in' => 'cubic-bezier(0.4, 0, 1, 1)',
            'out' => 'cubic-bezier(0, 0, 0.2, 1)',
            'in-out' => 'cubic-bezier(0.4, 0, 0.2, 1)',
        ];

        return $this->isArbitrary ? $this->value : ($timingFunctions[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = ['linear', 'in', 'out', 'in-out'];
        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        // Check if the value is a valid cubic-bezier function
        if (preg_match('/^cubic-bezier\(\s*(-?\d*\.?\d+)\s*,\s*(-?\d*\.?\d+)\s*,\s*(-?\d*\.?\d+)\s*,\s*(-?\d*\.?\d+)\s*\)$/', $this->value, $matches)) {
            // Validate that each parameter is between 0 and 1
            for ($i = 1; $i <= 4; $i++) {
                $param = floatval($matches[$i]);
                if ($param < 0 || $param > 1) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^ease-(linear|in|out|in-out|\[.+\])$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = trim($value, '[]');
                $instance = new self($value, true);
                return $instance->isValidArbitraryValue() ? $instance : null;
            }
            return new self($value, false);
        }
        return null;
    }
}