<?php

namespace Raakkan\PhpTailwind\Tailwind\Transforms;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class TranslateClass extends AbstractTailwindClass
{
    private $isArbitrary;

    private $axis;

    private $isNegative;

    public function __construct(string $value, string $axis = '', bool $isArbitrary = false, bool $isNegative = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
        $this->axis = $axis;
        $this->isNegative = $isNegative;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $translateValue = $this->getTranslateValue();
        $property = $this->axis === '-x' ? '--tw-translate-x' : '--tw-translate-y';

        $selector = $this->buildSelector();
        $css = "{$selector}{{$property}:{$translateValue};";
        $css .= 'transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}';

        return $css;
    }

    private function getTranslateValue(): string
    {
        $value = $this->isArbitrary ? $this->value : $this->getFixedValue();

        return $this->isNegative ? "-{$value}" : $value;
    }

    private function getFixedValue(): string
    {
        $fixedValues = $this->getFixedValues();

        return $fixedValues[$this->value] ?? $this->value;
    }

    private function getFixedValues(): array
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
            '1/2' => '50%',
            '1/3' => '33.333333%',
            '2/3' => '66.666667%',
            '1/4' => '25%',
            '2/4' => '50%',
            '3/4' => '75%',
            'full' => '100%',
        ];
    }

    private function buildSelector(): string
    {
        $prefix = $this->isNegative ? '-' : '';
        if ($this->isArbitrary) {
            return ".{$prefix}translate{$this->axis}-[{$this->value}]";
        }

        return ".{$prefix}translate{$this->axis}-{$this->value}";
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_merge(
            array_keys($this->getFixedValues()),
            ['1/2', '1/3', '2/3', '1/4', '2/4', '3/4', 'full']
        );

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        // Check if the value is numeric or a valid CSS length
        return is_numeric($this->value) || preg_match('/^\d+(\.\d+)?(px|rem|em|%|vh|vw)$/', $this->value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(-)?translate(-[xy])?-(\[.*?\]|\S+)$/', $class, $matches)) {
            $isNegative = ! empty($matches[1]);
            $axis = $matches[2] ?? '';
            $value = $matches[3];
            $isArbitrary = strpos($value, '[') !== false;

            if ($isArbitrary) {
                $value = trim($value, '[]');
            }

            return new self($value, $axis, $isArbitrary, $isNegative);
        }

        return null;
    }
}
