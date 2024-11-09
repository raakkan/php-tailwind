<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BackdropContrastClass extends AbstractTailwindClass
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

        $contrastValue = $this->getContrastValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;

        return ".backdrop-contrast-{$classValue}{--tw-backdrop-contrast:contrast({$contrastValue});-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}";
    }

    private function getContrastValue(): string
    {
        $contrasts = [
            '0' => '0',
            '50' => '.5',
            '75' => '.75',
            '100' => '1',
            '125' => '1.25',
            '150' => '1.5',
            '200' => '2',
        ];

        return $this->isArbitrary ? $this->value : ($contrasts[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['0', '50', '75', '100', '125', '150', '200'];

        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^backdrop-contrast-(\[.+\]|0|50|75|100|125|150|200)$/', $class, $matches)) {
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
