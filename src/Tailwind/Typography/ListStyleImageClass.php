<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class ListStyleImageClass extends AbstractTailwindClass
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
        $listStyleImageValue = $this->getListStyleImageValue();

        return ".list-image-{$classValue}{list-style-image:{$listStyleImageValue};}";
    }

    private function getListStyleImageValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->getListStyleImages()[$this->value];
    }

    private function getListStyleImages(): array
    {
        return [
            'none' => 'none',
            // Add more predefined list style images here if Tailwind adds them in the future
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getListStyleImages());
        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        // Allow URL function and other valid CSS list-style-image values
        return preg_match('/^(url\(.+\)|none|inherit|initial|revert|unset)$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^list-image-((?:\[.+\]|none))$/', $class, $matches)) {
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