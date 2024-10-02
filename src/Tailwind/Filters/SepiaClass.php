<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class SepiaClass extends AbstractTailwindClass
{
    private $isArbitrary;

    public function __construct(string $value, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $sepiaValue = $this->getSepiaValue();
        $classValue = $this->getClassValue();
        
        return ".sepia{$classValue}{--tw-sepia:sepia({$sepiaValue});filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}";
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
        if (preg_match('/^sepia(-(\[.+\]|0))?$/', $class, $matches)) {
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