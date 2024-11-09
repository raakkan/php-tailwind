<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BackdropSepiaClass extends AbstractTailwindClass
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

        $sepiaValue = $this->getSepiaValue();
        $classValue = $this->getClassValue();

        return ".backdrop-sepia{$classValue}{--tw-backdrop-sepia:sepia({$sepiaValue});-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}";
    }

    private function getClassValue(): string
    {
        if ($this->isArbitrary) {
            return "-\\[{$this->escapeArbitraryValue($this->value)}\\]";
        }
        if ($this->value === '') {
            return '';
        }

        return "-{$this->value}";
    }

    private function getSepiaValue(): string
    {
        $sepias = [
            '0' => '0',
            '' => '100%',
        ];

        return $this->isArbitrary ? $this->value : ($sepias[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['0', ''];

        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^backdrop-sepia(-(\[.+\]|0))?$/', $class, $matches)) {
            $value = $matches[2] ?? '';
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }

            return new self($value, $isArbitrary);
        }

        return null;
    }
}
