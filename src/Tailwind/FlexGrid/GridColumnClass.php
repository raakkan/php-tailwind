<?php

namespace Raakkan\PhpTailwind\Tailwind\FlexGrid;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class GridColumnClass extends AbstractTailwindClass
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
            $escapedClassValue = $this->encodeArbitraryValue($classValue);
        } else {
            $escapedClassValue = preg_replace('/[\/\.]/', '\\\\$0', $classValue);
        }

        $cssValue = $this->calculateValue();
        
        return ".grid-cols-{$escapedClassValue}{grid-template-columns:{$cssValue};}";
    }

    private function calculateValue(): string
    {
        switch ($this->value) {
            case 'none':
                return 'none';
            case 'subgrid':
                return 'subgrid';
            default:
                if ($this->isArbitrary) {
                    return $this->decodeArbitraryValue(trim($this->value, '[]'));
                }
                return "repeat({$this->value},minmax(0,1fr))";
        }
    }

    private function encodeArbitraryValue(string $value): string
    {
        $value = trim($value, '[]');
        $value = str_replace([',', ')', '('], ['\\2c ', '\\)', '\\('], $value);
        return '\[' . $value . '\]';
    }

    private function decodeArbitraryValue(string $value): string
    {
        $value = str_replace('\\2c', ',', $value);
        $value = str_replace('_', ' ', $value);
        return $value;
    }

    private function isValidValue(): bool
    {
        $validValues = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', 'none', 'subgrid'];
        
        if (in_array($this->value, $validValues)) {
            return true;
        }

        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue($this->value);
        }
        
        return false;
    }

    private function isValidArbitraryValue($value): bool
    {
        $value = trim($value, '[]');
        // You might want to implement a more sophisticated validation for arbitrary values
        return !empty($value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^grid-cols-(.+)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            return new self($value, $isArbitrary);
        }
        return null;
    }
}