<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class LetterSpacingClass extends AbstractTailwindClass
{
    private $isArbitrary;

    public function __construct(string $value, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $letterSpacingValue = $this->getLetterSpacingValue();

        return ".tracking-{$classValue}{letter-spacing:{$letterSpacingValue};}";
    }

    private function getLetterSpacingValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->getLetterSpacings()[$this->value];
    }

    private function getLetterSpacings(): array
    {
        return [
            'tighter' => '-0.05em',
            'tight' => '-0.025em',
            'normal' => '0em',
            'wide' => '0.025em',
            'wider' => '0.05em',
            'widest' => '0.1em',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getLetterSpacings());
        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        // Allow numbers with units (px, em, rem, etc.) and calc() function
        return preg_match('/^(-?\d*\.?\d+([a-z]{2,}|%)|calc\(.+\))$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^tracking-((?:\[.+\]|tighter|tight|normal|wide|wider|widest))$/', $class, $matches)) {
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