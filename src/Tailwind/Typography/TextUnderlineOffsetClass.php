<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class TextUnderlineOffsetClass extends AbstractTailwindClass
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
        $offsetValue = $this->getOffsetValue();

        return ".underline-offset-{$classValue}{text-underline-offset:{$offsetValue};}";
    }

    private function getOffsetValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->getOffsetValues()[$this->value];
    }

    private function getOffsetValues(): array
    {
        return [
            'auto' => 'auto',
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

        $validValues = array_keys($this->getOffsetValues());

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Allow lengths and percentages
        return preg_match('/^(\d+(\.\d+)?(px|em|rem|%)|calc\(.+\))$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^underline-offset-((?:\[.+\]|auto|0|1|2|4|8))$/', $class, $matches)) {
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
