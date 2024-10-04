<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\StaticClass;

class FontWeightClass extends AbstractTailwindClass
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
            if (StaticClass::parse('font-'.$this->value)) {
                return StaticClass::parse('font-'.$this->value)->toCss();
            } else {
                return '';
            }
        }

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $fontWeightValue = $this->getFontWeightValue();

        return ".font-{$classValue}{font-weight:{$fontWeightValue};}";
    }

    private function getFontWeightValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->getFontWeights()[$this->value];
    }

    private function getFontWeights(): array
    {
        return [
            'thin' => '100',
            'extralight' => '200',
            'light' => '300',
            'normal' => '400',
            'medium' => '500',
            'semibold' => '600',
            'bold' => '700',
            'extrabold' => '800',
            'black' => '900',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getFontWeights());
        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        // Allow special characters and functions
        return preg_match('/^(\d+(\.\d+)?(!important)?|calc\(.+\))$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^font-((?:\[.+\]|thin|extralight|light|normal|medium|semibold|bold|extrabold|black))$/', $class, $matches)) {
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