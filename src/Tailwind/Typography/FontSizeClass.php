<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class FontSizeClass extends AbstractTailwindClass
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
        $fontSizeValue = $this->getFontSizeValue();

        return ".text-{$classValue}{font-size:{$fontSizeValue[0]};line-height:{$fontSizeValue[1]};}";
    }

    private function getFontSizeValue(): array
    {
        if ($this->isArbitrary) {
            return [trim($this->value, '[]'), 'normal'];
        }

        return $this->calculateFontSize($this->value);
    }

    private function calculateFontSize(string $value): array
    {
        $fontSizes = $this->getFontSizes();

        if (isset($fontSizes[$value])) {
            return $fontSizes[$value];
        }

        // Default to 'base' size if not found
        return $fontSizes['base'];
    }

    private function getFontSizes(): array
    {
        return [
            'xs' => ['0.75rem', '1rem'],
            'sm' => ['0.875rem', '1.25rem'],
            'base' => ['1rem', '1.5rem'],
            'lg' => ['1.125rem', '1.75rem'],
            'xl' => ['1.25rem', '1.75rem'],
            '2xl' => ['1.5rem', '2rem'],
            '3xl' => ['1.875rem', '2.25rem'],
            '4xl' => ['2.25rem', '2.5rem'],
            '5xl' => ['3rem', '1'],
            '6xl' => ['3.75rem', '1'],
            '7xl' => ['4.5rem', '1'],
            '8xl' => ['6rem', '1'],
            '9xl' => ['8rem', '1'],
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getFontSizes());
        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Check for valid CSS length units or functions
        $validUnits = ['px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax', 'ex', 'ch', 'cm', 'mm', 'in', 'pt', 'pc'];
        $unitPattern = implode('|', $validUnits);
        $numberPattern = '-?\d*\.?\d+';
        $functionPattern = '(calc|clamp|max|min)\\([^()]+\\)';

        $pattern = "/^({$numberPattern}({$unitPattern})|{$functionPattern})$/";

        return preg_match($pattern, $value) === 1;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^text-((?:\[.+\]|xs|sm|base|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl|8xl|9xl))$/', $class, $matches)) {
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
        
    //     // Escape special characters, but keep commas unescaped
    //     $value = preg_replace('/([^a-zA-Z0-9,._()-])/', '\\\\$1', $value);
        
    //     return $value;
    // }
}