<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class ListStyleTypeClass extends AbstractTailwindClass
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
        $listStyleTypeValue = $this->getListStyleTypeValue();

        return ".list-{$classValue}{list-style-type:{$listStyleTypeValue};}";
    }

    private function getListStyleTypeValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->getListStyleTypes()[$this->value];
    }

    private function getListStyleTypes(): array
    {
        return [
            'none' => 'none',
            'disc' => 'disc',
            'decimal' => 'decimal',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getListStyleTypes());
        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        // Allow any valid CSS list-style-type value
        return preg_match('/^[a-zA-Z-]+$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^list-((?:\[.+\]|none|disc|decimal))$/', $class, $matches)) {
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
    //     $value = preg_replace('/([^a-zA-Z0-9-])/', '\\\\$1', $value);
        
    //     return $value;
    // }
}