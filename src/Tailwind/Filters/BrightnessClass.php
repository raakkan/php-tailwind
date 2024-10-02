<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BrightnessClass extends AbstractTailwindClass
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

        $brightnessValue = $this->getBrightnessValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        
        return ".brightness-{$classValue}{--tw-brightness:brightness({$brightnessValue});filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}";
    }

    private function getBrightnessValue(): string
    {
        $brightnesses = [
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
            '200' => '2',
        ];

        return $this->isArbitrary ? $this->value : ($brightnesses[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['0', '50', '75', '90', '95', '100', '105', '110', '125', '150', '200'];
        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^brightness-(\[.+\]|0|50|75|90|95|100|105|110|125|150|200)$/', $class, $matches)) {
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