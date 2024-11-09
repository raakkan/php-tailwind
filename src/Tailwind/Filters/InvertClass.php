<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class InvertClass extends AbstractTailwindClass
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

        $invertValue = $this->getInvertValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;

        return ".invert-{$classValue}{--tw-invert:invert({$invertValue});filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}";
    }

    private function getInvertValue(): string
    {
        $inverts = [
            '0' => '0',
            '100' => '100%',
        ];

        return $this->isArbitrary ? $this->value : ($inverts[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['0', '100'];

        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^invert-(\[.+\]|0|100)$/', $class, $matches)) {
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
