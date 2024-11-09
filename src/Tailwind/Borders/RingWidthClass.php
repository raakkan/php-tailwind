<?php

namespace Raakkan\PhpTailwind\Tailwind\Borders;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class RingWidthClass extends AbstractTailwindClass
{
    private $isArbitrary;

    private $isInset;

    public function __construct(string $value, bool $isArbitrary = false, bool $isInset = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
        $this->isInset = $isInset;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $insetValue = $this->isInset ? 'inset' : '';
        $ringWidth = $this->getRingWidth();

        $css = ".ring{$this->getClassSuffix()} {";
        $css .= '--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);';
        $css .= "--tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc({$ringWidth} + var(--tw-ring-offset-width)) var(--tw-ring-color);";
        $css .= 'box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);';

        if ($this->isInset) {
            $css .= '--tw-ring-inset: inset;';
        }

        $css .= '}';

        return $css;
    }

    private function getClassSuffix(): string
    {
        if ($this->isInset) {
            return '-inset';
        }

        if ($this->isArbitrary) {
            return "-\[{$this->escapeArbitraryValue($this->value)}\]";
        }

        return $this->value === 'DEFAULT' ? '' : "-{$this->value}";
    }

    private function getRingWidth(): string
    {
        if ($this->isArbitrary) {
            return $this->value;
        }

        $ringWidths = [
            '0' => '0px',
            '1' => '1px',
            '2' => '2px',
            '4' => '4px',
            '8' => '8px',
            'DEFAULT' => '3px',
        ];

        return $ringWidths[$this->value] ?? $this->value;
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = ['0', '1', '2', '4', '8', 'DEFAULT'];

        return in_array($this->value, $validValues) || $this->isInset;
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        return preg_match('/^[a-zA-Z0-9-_.%()]+$/', $value) === 1;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^ring(-inset|-(.+))?$/', $class, $matches)) {
            $isInset = ($matches[1] ?? '') === '-inset';
            $value = $matches[2] ?? 'DEFAULT';
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            if ($isArbitrary) {
                $value = trim($value, '[]');
            }

            return new self($value, $isArbitrary, $isInset);
        }

        return null;
    }
}
