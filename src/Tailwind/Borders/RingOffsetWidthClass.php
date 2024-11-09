<?php

namespace Raakkan\PhpTailwind\Tailwind\Borders;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class RingOffsetWidthClass extends AbstractTailwindClass
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

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $offsetValue = $this->getOffsetValue();

        return ".ring-offset-{$classValue}{--tw-ring-offset-width:{$offsetValue};}";
    }

    private function getOffsetValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        $ringOffsetWidths = [
            '0' => '0px',
            '1' => '1px',
            '2' => '2px',
            '4' => '4px',
            '8' => '8px',
        ];

        return $ringOffsetWidths[$this->value] ?? $this->value;
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = ['0', '1', '2', '4', '8'];

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        $validUnits = ['px', 'em', 'rem', '%', 'vw', 'vh'];
        $pattern = '/^(-?\d*\.?\d+)('.implode('|', $validUnits).')$/';

        return preg_match($pattern, $value) || preg_match('/^(calc|clamp|min|max)\(.*\)$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^ring-offset-(.+)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            return new self($value, $isArbitrary);
        }

        return null;
    }
}
