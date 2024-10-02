<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class GrayscaleClass extends AbstractTailwindClass
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

        $grayscaleValue = $this->getGrayscaleValue();
        $classValue = $this->value === '' ? '' : "-{$this->value}";
        if ($this->isArbitrary) {
            $classValue = "-\\[{$this->escapeArbitraryValue($this->value)}\\]";
        }
        
        return ".grayscale{$classValue}{--tw-grayscale:grayscale({$grayscaleValue});filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}";
    }

    private function getGrayscaleValue(): string
    {
        $grayscales = [
            '0' => '0',
            '' => '100%',
        ];

        return $this->isArbitrary ? $this->value : ($grayscales[$this->value] ?? '100%');
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
        if (preg_match('/^grayscale(-(\[.+\]|0))?$/', $class, $matches)) {
            $value = isset($matches[2]) ? $matches[2] : '';
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }
            return new self($value, $isArbitrary);
        }
        return null;
    }
}