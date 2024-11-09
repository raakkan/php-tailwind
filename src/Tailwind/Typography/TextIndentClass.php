<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class TextIndentClass extends AbstractTailwindClass
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
        $indentValue = $this->getIndentValue();

        return ".indent-{$classValue}{text-indent:{$indentValue};}";
    }

    private function getIndentValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->getTextIndents()[$this->value];
    }

    private function getTextIndents(): array
    {
        return [
            '0' => '0px',
            'px' => '1px',
            '0.5' => '0.125rem',
            '1' => '0.25rem',
            '1.5' => '0.375rem',
            '2' => '0.5rem',
            '2.5' => '0.625rem',
            '3' => '0.75rem',
            '3.5' => '0.875rem',
            '4' => '1rem',
            '5' => '1.25rem',
            '6' => '1.5rem',
            '7' => '1.75rem',
            '8' => '2rem',
            '9' => '2.25rem',
            '10' => '2.5rem',
            '11' => '2.75rem',
            '12' => '3rem',
            '14' => '3.5rem',
            '16' => '4rem',
            '20' => '5rem',
            '24' => '6rem',
            '28' => '7rem',
            '32' => '8rem',
            '36' => '9rem',
            '40' => '10rem',
            '44' => '11rem',
            '48' => '12rem',
            '52' => '13rem',
            '56' => '14rem',
            '60' => '15rem',
            '64' => '16rem',
            '72' => '18rem',
            '80' => '20rem',
            '96' => '24rem',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getTextIndents());

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Allow valid CSS length values
        return preg_match('/^(-?\d*\.?\d+)(cm|mm|in|px|pt|pc|em|ex|ch|rem|vw|vh|vmin|vmax|%)$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^indent-((?:\[.+\]|0|px|0\.5|1|1\.5|2|2\.5|3|3\.5|4|5|6|7|8|9|10|11|12|14|16|20|24|28|32|36|40|44|48|52|56|60|64|72|80|96))$/', $class, $matches)) {
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
