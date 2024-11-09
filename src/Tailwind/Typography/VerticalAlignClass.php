<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class VerticalAlignClass extends AbstractTailwindClass
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
        $verticalAlignValue = $this->getVerticalAlignValue();

        return ".align-{$classValue}{vertical-align:{$verticalAlignValue};}";
    }

    private function getVerticalAlignValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->getVerticalAligns()[$this->value];
    }

    private function getVerticalAligns(): array
    {
        return [
            'baseline' => 'baseline',
            'top' => 'top',
            'middle' => 'middle',
            'bottom' => 'bottom',
            'text-top' => 'text-top',
            'text-bottom' => 'text-bottom',
            'sub' => 'sub',
            'super' => 'super',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getVerticalAligns());

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Allow lengths, percentages, and other valid CSS vertical-align values
        return preg_match('/^(\d+(\.\d+)?(px|em|rem|%)|calc\(.+\)|auto|inherit|initial|revert|unset)$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^align-((?:\[.+\]|baseline|top|middle|bottom|text-top|text-bottom|sub|super))$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            return new self($value, $isArbitrary);
        }

        return null;
    }

    protected function escapeArbitraryValue(string $value): string
    {
        // Remove square brackets
        $value = trim($value, '[]');

        // Escape special characters
        $value = preg_replace('/([^a-zA-Z0-9])/', '\\\\$1', $value);

        return $value;
    }
}
