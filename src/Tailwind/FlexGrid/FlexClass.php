<?php

namespace Raakkan\PhpTailwind\Tailwind\FlexGrid;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class FlexClass extends AbstractTailwindClass
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
        
        $classValue = $this->value;

        if ($this->isArbitrary) {
            $escapedClassValue = str_replace(['%', ' '], ['\%', '_'], $classValue);
            $escapedClassValue = preg_replace('/([[\]])/', '\\\\$1', $escapedClassValue);
        } else {
            $escapedClassValue = preg_replace('/[\/\.]/', '\\\\$0', $classValue);
        }

        $cssValue = $this->calculateValue();
        
        return ".flex-{$escapedClassValue}{flex:{$cssValue};}";
    }

    private function isValidValue(): bool
    {
        $validValues = ['1', 'auto', 'initial', 'none'];
        
        if (in_array($this->value, $validValues)) {
            return true;
        }

        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue($this->value);
        }
        
        return false;
    }

    private function calculateValue(): string
    {
        if ($this->value === 'auto') {
            return '1 1 auto';
        }

        if ($this->value === 'initial') {
            return '0 1 auto';
        }

        if ($this->value === 'none') {
            return 'none';
        }

        if ($this->value === '1') {
            return '1 1 0%';
        }

        if ($this->isArbitrary) {
            $value = trim($this->value, '[]');
            return str_replace('_', ' ', $value);
        }

        return $this->value;
    }

    private function isValidArbitraryValue($value): bool
    {
        // Remove brackets for validation
        $innerValue = trim($value, '[]');
        
        // Replace underscores with spaces for validation
        $innerValue = str_replace('_', ' ', $innerValue);
        
        // Check for valid flex shorthand syntax
        if (preg_match('/^(\d+(\s+\d+(\s+(\d+(%|px|em|rem)|auto|none|inherit|initial|unset)))?)$/', $innerValue)) {
            return true;
        }

        // Check for single number
        if (is_numeric($innerValue)) {
            return true;
        }

        return false;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^flex-(.+)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            return new self($value, $isArbitrary);
        }
        return null;
    }
}