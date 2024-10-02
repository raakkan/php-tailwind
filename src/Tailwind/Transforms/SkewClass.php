<?php

namespace Raakkan\PhpTailwind\Tailwind\Transforms;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class SkewClass extends AbstractTailwindClass
{
    private $axis;
    private $isArbitrary;
    private $isNegative;

    public function __construct(string $value, string $axis, bool $isArbitrary = false, bool $isNegative = false)
    {
        parent::__construct($value);
        $this->axis = $axis;
        $this->isArbitrary = $isArbitrary;
        $this->isNegative = $isNegative;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $skewValue = $this->getSkewValue();
        $classValue = $this->value;
        $prefix = '';
        if ($this->isNegative && !$this->isArbitrary) {
            $classValue = "{$this->value}";
            $prefix = '-';
        }
        if ($this->isArbitrary) {
            $classValue = "\\[{$this->escapeArbitraryValue($this->value)}\\]";
        }
        
        $property = "--tw-skew-{$this->axis}";
        return ".{$prefix}skew-{$this->axis}-{$classValue}{{$property}:{$skewValue};transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}";
    }

    private function getSkewValue(): string
    {
        $skews = [
            '0' => '0deg',
            '1' => '1deg',
            '2' => '2deg',
            '3' => '3deg',
            '6' => '6deg',
            '12' => '12deg',
        ];

        $value = $this->isArbitrary ? $this->value : ($skews[$this->value] ?? '0deg');
        return $this->isNegative ? "-{$value}" : $value;
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['0', '1', '2', '3', '6', '12'];
        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(-?)skew-(x|y)(-(\[.+\]|0|1|2|3|6|12))?$/', $class, $matches)) {
            $isNegative = $matches[1] === '-';
            $axis = $matches[2];
            $value = isset($matches[4]) ? $matches[4] : '0';
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = trim($value, '[]');
                if ($isNegative) {
                    $value = "-{$value}";
                    $isNegative = false; // Reset isNegative as it's now part of the value
                }
            }
            return new self($value, $axis, $isArbitrary, $isNegative);
        }
        return null;
    }
}