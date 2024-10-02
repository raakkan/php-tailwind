<?php

namespace Raakkan\PhpTailwind\Tailwind\SVG;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class FillClass extends AbstractTailwindClass
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
        $fillValue = $this->getFillValue();
        
        return ".fill-{$classValue} {fill: {$fillValue};}";
    }

    private function getFillValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        $specialValues = ['none', 'inherit', 'current', 'transparent'];
        if (in_array($this->value, $specialValues)) {
            return $this->value === 'current' ? 'currentColor' : $this->value;
        }

        $colors = $this->getColors();
        $colorName = str_replace(['fill-'], '', $this->value);
        return $colors[$colorName]['hex'] ?? '';
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_merge(
            ['none', 'inherit', 'current', 'transparent'],
            array_keys($this->getColors())
        );
        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        return preg_match('/^(#[0-9A-Fa-f]{3,8}|rgb\(.*\)|rgba\(.*\)|hsl\(.*\)|hsla\(.*\))$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^fill-((?:\[.+\]|none|inherit|current|transparent|black|white|slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)(?:-\d{1,3})?)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            return new self($value, $isArbitrary);
        }
        return null;
    }
}