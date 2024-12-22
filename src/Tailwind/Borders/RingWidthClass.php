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
        // Match exact 'ring' class first
        if ($class === 'ring') {
            return new self('DEFAULT', false, false);
        }

        // Match 'ring-inset'
        if ($class === 'ring-inset') {
            return new self('DEFAULT', false, true);
        }

        // Match standard ring widths: ring-{0|1|2|4|8}
        if (preg_match('/^ring-(\d+)$/', $class, $matches)) {
            $value = $matches[1];

            return new self($value, false, false);
        }

        // Match arbitrary ring width: ring-[10px]
        if (preg_match('/^ring-(\[.+\])$/', $class, $matches)) {
            $value = trim($matches[1], '[]');

            return new self($value, true, false);
        }

        // Return instance for invalid ring classes that start with 'ring-'
        if (str_starts_with($class, 'ring-')) {
            return new self($class, false, false);
        }

        return null;
    }
}
