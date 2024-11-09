<?php

namespace Raakkan\PhpTailwind\Tailwind\Tables;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BorderSpacingClass extends AbstractTailwindClass
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

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $spacingValue = $this->getBorderSpacingValue();

        $axisPrefix = $this->getAxisPrefix();
        $properties = $this->getBorderSpacingProperties();

        $css = ".border-spacing{$axisPrefix}-{$classValue}{";
        foreach ($properties as $property) {
            $css .= "{$property}:{$spacingValue};";
        }
        $css .= 'border-spacing:var(--tw-border-spacing-x) var(--tw-border-spacing-y);}';

        return $css;
    }

    private function getBorderSpacingValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        $spacingValues = $this->getBorderSpacingValues();

        return $spacingValues[$this->value] ?? $this->value;
    }

    private function getBorderSpacingValues(): array
    {
        return [
            '0' => '0px',
            'px' => '1px',
            '0.5' => '0.125rem',
            '1' => '0.25rem',
            '1.5' => '0.375rem',
            '2' => '0.5rem',
            '2.5' => '0.625rem',
            '3' => '0.75rem',
            '3.5' => '0.875rem',
            '4' => '1rem',
            '5' => '1.25rem',
            '6' => '1.5rem',
            '7' => '1.75rem',
            '8' => '2rem',
            '9' => '2.25rem',
            '10' => '2.5rem',
            '11' => '2.75rem',
            '12' => '3rem',
            '14' => '3.5rem',
            '16' => '4rem',
            '20' => '5rem',
            '24' => '6rem',
            '28' => '7rem',
            '32' => '8rem',
            '36' => '9rem',
            '40' => '10rem',
            '44' => '11rem',
            '48' => '12rem',
            '52' => '13rem',
            '56' => '14rem',
            '60' => '15rem',
            '64' => '16rem',
            '72' => '18rem',
            '80' => '20rem',
            '96' => '24rem',
        ];
    }

    private function getAxisPrefix(): string
    {
        return $this->axis ? "-{$this->axis}" : '';
    }

    private function getBorderSpacingProperties(): array
    {
        $properties = ['--tw-border-spacing-x', '--tw-border-spacing-y'];

        if ($this->axis === 'x') {
            return ['--tw-border-spacing-x'];
        } elseif ($this->axis === 'y') {
            return ['--tw-border-spacing-y'];
        }

        return $properties;
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_merge(
            array_keys($this->getBorderSpacingValues()),
            ['px', '0.5', '1.5', '2.5', '3.5']
        );

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
        if (preg_match('/^border-spacing(-[xy])?-(.+)$/', $class, $matches)) {
            $axis = ltrim($matches[1] ?? '', '-');
            $value = $matches[2];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            return new self($value, $axis, $isArbitrary);
        }

        return null;
    }
}
