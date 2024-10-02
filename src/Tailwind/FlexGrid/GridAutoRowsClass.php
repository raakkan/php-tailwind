<?php

namespace Raakkan\PhpTailwind\Tailwind\FlexGrid;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class GridAutoRowsClass extends AbstractTailwindClass
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
            $escapedClassValue = $this->escapeArbitraryValue($classValue);
        } else {
            $escapedClassValue = preg_replace('/[\/\.]/', '\\\\$0', $classValue);
        }

        $cssValue = $this->calculateValue();
        
        return ".auto-rows-{$escapedClassValue}{grid-auto-rows:{$cssValue};}";
    }

    protected function escapeArbitraryValue(string $value): string
    {
        $value = trim($value, '[]');
        $value = str_replace(['%', '(', ')', ','], ['\%', '\(', '\)', '\2c '], $value);
        return "\\[{$value}\\]";
    }

    private function isValidValue(): bool
    {
        $validValues = ['auto', 'min', 'max', 'fr'];
        
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
        switch ($this->value) {
            case 'auto':
                return 'auto';
            case 'min':
                return 'min-content';
            case 'max':
                return 'max-content';
            case 'fr':
                return 'minmax(0, 1fr)';
            default:
                if ($this->isArbitrary) {
                    $value = trim($this->value, '[]');
                    return preg_replace('/\s*,\s*/', ', ', str_replace('_', ' ', $value));
                }
                return $this->value;
        }
    }

    private function isValidArbitraryValue($value): bool
    {
        // Remove brackets for validation
        $innerValue = trim($value, '[]');
        
        // Replace underscores with spaces for validation
        $innerValue = str_replace('_', ' ', $innerValue);
        
        // More permissive regex pattern
        if (preg_match('/^(auto|min-content|max-content|minmax\(.+\)|fit-content\(.+\)|\d+(\.\d+)?(px|em|rem|%|fr)|repeat\(.+\)|calc\(.+\))$/', $innerValue)) {
            return true;
        }

        return false;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^auto-rows-(.+)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            return new self($value, $isArbitrary);
        }
        return null;
    }
}