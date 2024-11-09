<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class TextDecorationThicknessClass extends AbstractTailwindClass
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
        $thicknessValue = $this->getThicknessValue();

        return ".decoration-{$classValue}{text-decoration-thickness:{$thicknessValue};}";
    }

    private function getThicknessValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->getThicknessValues()[$this->value];
    }

    private function getThicknessValues(): array
    {
        return [
            'auto' => 'auto',
            'from-font' => 'from-font',
            '0' => '0px',
            '1' => '1px',
            '2' => '2px',
            '4' => '4px',
            '8' => '8px',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getThicknessValues());

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Allow lengths and percentages
        return preg_match('/^(\d+(\.\d+)?(px|em|rem|%)|0)$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^decoration-((?:\[.+\]|auto|from-font|0|1|2|4|8))$/', $class, $matches)) {
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
    //     $value = preg_replace('/([^a-zA-Z0-9])/', '\\\\$1', $value);

    //     return $value;
    // }
}
