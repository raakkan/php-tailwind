<?php

namespace Raakkan\PhpTailwind\Tailwind\Transforms;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class ScaleClass extends AbstractTailwindClass
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

        $scaleValue = $this->getScaleValue();
        $properties = $this->getScaleProperties();

        $selector = $this->isArbitrary
            ? ".scale{$this->axis}-[{$this->value}]"
            : ".scale{$this->axis}-{$this->value}";

        $css = "{$selector}{";
        foreach ($properties as $property => $value) {
            $css .= "{$property}:{$value};";
        }
        $css .= 'transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}';

        return $css;
    }

    private function getScaleValue(): string
    {
        if ($this->isArbitrary) {
            return $this->value;
        }

        $scaleValues = [
            '0' => '0',
            '50' => '.5',
            '75' => '.75',
            '90' => '.9',
            '95' => '.95',
            '100' => '1',
            '105' => '1.05',
            '110' => '1.1',
            '125' => '1.25',
            '150' => '1.5',
        ];

        return $scaleValues[$this->value] ?? $this->value;
    }

    private function getScaleProperties(): array
    {
        $scaleValue = $this->getScaleValue();

        if ($this->axis === '-x') {
            return ['--tw-scale-x' => $scaleValue];
        } elseif ($this->axis === '-y') {
            return ['--tw-scale-y' => $scaleValue];
        } else {
            return [
                '--tw-scale-x' => $scaleValue,
                '--tw-scale-y' => $scaleValue,
            ];
        }
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = ['0', '50', '75', '90', '95', '100', '105', '110', '125', '150'];

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        // Check if the value is numeric and the brackets are balanced
        return is_numeric($this->value) &&
               substr_count($this->axis.'-['.$this->value.']', '[') === substr_count($this->axis.'-['.$this->value.']', ']');
    }

    public static function parse(string $class): ?self
    {
        // Updated regex to be more permissive
        if (preg_match('/^scale(-[xy])?-(\[.*?]?|\d+]?)$/', $class, $matches)) {
            $axis = $matches[1] ?? '';
            $value = $matches[2];
            $isArbitrary = strpos($value, '[') !== false || strpos($value, ']') !== false;

            if ($isArbitrary) {
                $value = trim($value, '[]');
            }

            // Return an instance even for invalid arbitrary values
            return new self($value, $axis, $isArbitrary);
        }

        return null;
    }
}
