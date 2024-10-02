<?php

namespace Raakkan\PhpTailwind\Tailwind\FlexGrid;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class OrderClass extends AbstractTailwindClass
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
            $escapedClassValue = '\[' . $this->escapeArbitraryValue($classValue) . '\]';
        } else {
            $escapedClassValue = preg_replace('/[\/\.]/', '\\\\$0', $classValue);
        }

        $cssValue = $this->calculateValue();
        
        return ".order-{$escapedClassValue}{order:{$cssValue};}";
    }

    private function isValidValue(): bool
    {
        $validValues = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', 'first', 'last', 'none'];
        
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
            case 'first':
                return '-9999';
            case 'last':
                return '9999';
            case 'none':
                return '0';
            default:
                return $this->isArbitrary ? trim($this->value, '[]') : $this->value;
        }
    }

    private function isValidArbitraryValue($value): bool
    {
        $value = trim($value, '[]');
        return is_numeric($value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^order-(.+)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            return new self($value, $isArbitrary);
        }
        return null;
    }
}