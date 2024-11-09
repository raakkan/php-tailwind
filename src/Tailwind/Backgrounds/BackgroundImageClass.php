<?php

namespace Raakkan\PhpTailwind\Tailwind\Backgrounds;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BackgroundImageClass extends AbstractTailwindClass
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

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $bgImageValue = $this->getBgImageValue();

        return ".bg-{$classValue}{background-image:{$bgImageValue};}";
    }

    private function getBgImageValue(): string
    {
        if ($this->isArbitrary) {
            return str_replace('_', ' ', trim($this->value, '[]'));
        }

        return $this->getBgImages()[$this->value];
    }

    private function getBgImages(): array
    {
        return [
            'none' => 'none',
            'gradient-to-t' => 'linear-gradient(to top, var(--tw-gradient-stops))',
            'gradient-to-tr' => 'linear-gradient(to top right, var(--tw-gradient-stops))',
            'gradient-to-r' => 'linear-gradient(to right, var(--tw-gradient-stops))',
            'gradient-to-br' => 'linear-gradient(to bottom right, var(--tw-gradient-stops))',
            'gradient-to-b' => 'linear-gradient(to bottom, var(--tw-gradient-stops))',
            'gradient-to-bl' => 'linear-gradient(to bottom left, var(--tw-gradient-stops))',
            'gradient-to-l' => 'linear-gradient(to left, var(--tw-gradient-stops))',
            'gradient-to-tl' => 'linear-gradient(to top left, var(--tw-gradient-stops))',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getBgImages());

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        // Allow url(), linear-gradient(), radial-gradient(), etc.
        $pattern = '/^(url\([^)]+\)|linear-gradient\([^)]+\)|radial-gradient\([^)]+\)|repeating-linear-gradient\([^)]+\)|repeating-radial-gradient\([^)]+\)|conic-gradient\([^)]+\))$/';

        return preg_match($pattern, $value) === 1;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^bg-((?:\[.+\]|none|gradient-to-[trblTRBL]{1,2}))$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            return new self($value, $isArbitrary);
        }

        return null;
    }

    // protected function escapeArbitraryValue(string $value): string
    // {
    //     // Remove square brackets
    //     $value = trim($value, '[]');

    //     // Escape special characters
    //     $value = preg_replace('/([^a-zA-Z0-9\s%_-])/', '\\\\$1', $value);

    //     return $value;
    // }
}
