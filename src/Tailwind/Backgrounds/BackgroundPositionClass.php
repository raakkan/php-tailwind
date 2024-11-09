<?php

namespace Raakkan\PhpTailwind\Tailwind\Backgrounds;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BackgroundPositionClass extends AbstractTailwindClass
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
        $bgPositionValue = $this->getBgPositionValue();

        return ".bg-{$classValue}{background-position:{$bgPositionValue};}";
    }

    private function getBgPositionValue(): string
    {
        if ($this->isArbitrary) {
            return str_replace('_', ' ', trim($this->value, '[]'));
        }

        return $this->getBgPositions()[$this->value];
    }

    private function getBgPositions(): array
    {
        return [
            'bottom' => 'bottom',
            'center' => 'center',
            'left' => 'left',
            'left-bottom' => 'left bottom',
            'left-top' => 'left top',
            'right' => 'right',
            'right-bottom' => 'right bottom',
            'right-top' => 'right top',
            'top' => 'top',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getBgPositions());

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        $value = str_replace('_', ' ', $value);
        // Allow percentage, pixel values, rem values, and keywords
        $pattern = '/^((\d+(%|px|rem)?|top|bottom|left|right|center|calc\([^)]+\)|var\([^)]+\))(\s+(\d+(%|px|rem)?|top|bottom|left|right|center|calc\([^)]+\)|var\([^)]+\)))?)$/';

        return preg_match($pattern, $value) === 1;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^bg-((?:\[.+\]|bottom|center|left|left-bottom|left-top|right|right-bottom|right-top|top))$/', $class, $matches)) {
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
