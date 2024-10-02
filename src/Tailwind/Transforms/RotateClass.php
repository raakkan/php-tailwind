<?php

namespace Raakkan\PhpTailwind\Tailwind\Transforms;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class RotateClass extends AbstractTailwindClass
{
    private $isArbitrary;
    private $isNegative;

    public function __construct(string $value, bool $isArbitrary = false, bool $isNegative = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
        $this->isNegative = $isNegative;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $rotateValue = $this->getRotateValue();
        $classValue = $this->value;
        if ($this->isNegative && !$this->isArbitrary) {
            $classValue = "-{$this->value}";
        }
        if ($this->isArbitrary) {
            $classValue = "\\[{$this->escapeArbitraryValue($this->value)}\\]";
        }
        
        return ".rotate-{$classValue}{--tw-rotate:{$rotateValue};transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));}";
    }

    private function getRotateValue(): string
    {
        $rotates = [
            '0' => '0deg',
            '1' => '1deg',
            '2' => '2deg',
            '3' => '3deg',
            '6' => '6deg',
            '12' => '12deg',
            '45' => '45deg',
            '90' => '90deg',
            '180' => '180deg',
        ];

        $value = $this->isArbitrary ? $this->value : ($rotates[$this->value] ?? '0deg');
        return $this->isNegative ? "-{$value}" : $value;
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['0', '1', '2', '3', '6', '12', '45', '90', '180'];
        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(-?)rotate(-(\[.+\]|0|1|2|3|6|12|45|90|180))?$/', $class, $matches)) {
            $isNegative = $matches[1] === '-';
            $value = isset($matches[3]) ? $matches[3] : '0';
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = trim($value, '[]');
                if ($isNegative) {
                    $value = "-{$value}";
                    $isNegative = false; // Reset isNegative as it's now part of the value
                }
            }
            return new self($value, $isArbitrary, $isNegative);
        }
        return null;
    }
}