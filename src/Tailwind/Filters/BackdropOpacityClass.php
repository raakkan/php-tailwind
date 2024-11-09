<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BackdropOpacityClass extends AbstractTailwindClass
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

        $opacityValue = $this->getOpacityValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;

        return ".backdrop-opacity-{$classValue}{--tw-backdrop-opacity:opacity({$opacityValue});-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}";
    }

    private function getOpacityValue(): string
    {
        $opacities = [
            '0' => '0',
            '5' => '0.05',
            '10' => '0.1',
            '20' => '0.2',
            '25' => '0.25',
            '30' => '0.3',
            '40' => '0.4',
            '50' => '0.5',
            '60' => '0.6',
            '70' => '0.7',
            '75' => '0.75',
            '80' => '0.8',
            '90' => '0.9',
            '95' => '0.95',
            '100' => '1',
        ];

        return $this->isArbitrary ? $this->value : ($opacities[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['0', '5', '10', '20', '25', '30', '40', '50', '60', '70', '75', '80', '90', '95', '100'];

        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^backdrop-opacity-(\[.+\]|0|5|10|20|25|30|40|50|60|70|75|80|90|95|100)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }

            return new self($value, $isArbitrary);
        }

        return null;
    }
}
