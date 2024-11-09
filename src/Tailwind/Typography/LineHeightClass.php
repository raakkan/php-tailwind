<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class LineHeightClass extends AbstractTailwindClass
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
        $lineHeightValue = $this->getLineHeightValue();

        return ".leading-{$classValue}{line-height:{$lineHeightValue};}";
    }

    private function getLineHeightValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->getLineHeights()[$this->value];
    }

    private function getLineHeights(): array
    {
        return [
            '3' => '.75rem', // 12px
            '4' => '1rem', // 16px
            '5' => '1.25rem', // 20px
            '6' => '1.5rem', // 24px
            '7' => '1.75rem', // 28px
            '8' => '2rem', // 32px
            '9' => '2.25rem', // 36px
            '10' => '2.5rem', // 40px
            'none' => '1',
            'tight' => '1.25',
            'snug' => '1.375',
            'normal' => '1.5',
            'relaxed' => '1.625',
            'loose' => '2',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getLineHeights());

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Allow numbers, decimals, rem, em, px, and percentages
        return preg_match('/^(\d+(\.\d+)?(rem|em|px|%)?|calc\(.+\))$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^leading-((?:\[.+\]|3|4|5|6|7|8|9|10|none|tight|snug|normal|relaxed|loose))$/', $class, $matches)) {
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
