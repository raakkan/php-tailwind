<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class HueRotateClass extends AbstractTailwindClass
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

        $hueRotateValue = $this->getHueRotateValue();
        $classValue = $this->value;
        if ($this->isNegative && !$this->isArbitrary) {
            $classValue = "-{$this->value}";
        }
        if ($this->isArbitrary) {
            $classValue = "\\[{$this->escapeArbitraryValue($this->value)}\\]";
        }
        
        return ".hue-rotate-{$classValue}{--tw-hue-rotate:hue-rotate({$hueRotateValue});filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}";
    }

    private function getHueRotateValue(): string
    {
        $hueRotates = [
            '0' => '0deg',
            '15' => '15deg',
            '30' => '30deg',
            '60' => '60deg',
            '90' => '90deg',
            '180' => '180deg',
        ];

        $value = $this->isArbitrary ? $this->value : ($hueRotates[$this->value] ?? '0deg');
        return $this->isNegative ? "-{$value}" : $value;
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['0', '15', '30', '60', '90', '180'];
        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(-?)hue-rotate(-(\[.+\]|0|15|30|60|90|180))?$/', $class, $matches)) {
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