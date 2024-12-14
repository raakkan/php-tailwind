<?php

namespace Raakkan\PhpTailwind\Tailwind\Backgrounds;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BackgroundSizeClass extends AbstractTailwindClass
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
        $bgSizeValue = $this->getBgSizeValue();

        return ".bg-{$classValue}{background-size:{$bgSizeValue};}";
    }

    private function getBgSizeValue(): string
    {
        if ($this->isArbitrary) {
            return str_replace('_', ' ', trim($this->value, '[]'));
        }

        return $this->getBgSizes()[$this->value];
    }

    private function getBgSizes(): array
    {
        return [
            'auto' => 'auto',
            'cover' => 'cover',
            'contain' => 'contain',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getBgSizes());

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        $value = str_replace('_', ' ', $value);
        // Allow percentage, pixel values, rem values, and keywords
        $pattern = '/^(auto|cover|contain|(\d+(%|px|rem|vw|vh)?(\s+\d+(%|px|rem|vw|vh)?)?)|calc\([^)]+\)|var\([^)]+\))$/';

        return preg_match($pattern, $value) === 1;
    }

    public static function parse(string $class): ?self
    {
        // Match background size patterns
        $pattern = '/^bg-('.
            '(?:\[(?:'.
                'auto|cover|contain|'.  // Keywords
                '\d+(?:%|px|rem|vw|vh)?(?:_\d+(?:%|px|rem|vw|vh)?)?|'.  // Single or double length values
                'calc\([^]]+\)|'.  // calc() expressions
                'var\([^]]+\)'.  // CSS variables
            ')\])|'.  // End arbitrary values
            '(?:auto|cover|contain))$/';  // Standard values

        if (preg_match($pattern, $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = str_starts_with($value, '[');

            if ($isArbitrary) {
                $value = trim($value, '[]');
            }

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
