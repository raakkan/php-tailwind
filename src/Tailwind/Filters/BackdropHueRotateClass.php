<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BackdropHueRotateClass extends AbstractTailwindClass
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
        
        return ".backdrop-hue-rotate-{$classValue}{--tw-backdrop-hue-rotate:hue-rotate({$hueRotateValue});-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}";
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
        if (preg_match('/^(-?)backdrop-hue-rotate(-(\[.+\]|0|15|30|60|90|180))?$/', $class, $matches)) {
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