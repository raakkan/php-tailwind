<?php

namespace Raakkan\PhpTailwind\Tailwind\Interactivity;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class CaretColorClass extends AbstractTailwindClass
{
    private $isArbitrary;

    private $opacity;

    public function __construct(string $value, bool $isArbitrary = false, ?string $opacity = null)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
        $this->opacity = $opacity;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $colorValue = $this->getColorValue();

        $css = ".caret-{$classValue}";
        if ($this->opacity !== null) {
            $css .= "\\/{$this->opacity}";
        }
        $css .= " {caret-color: {$colorValue};}";

        return $css;
    }

    private function getColorValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        $specialColors = ['inherit', 'current', 'transparent'];
        if (in_array($this->value, $specialColors)) {
            return $this->value === 'current' ? 'currentColor' : $this->value;
        }

        $colors = $this->getColors();
        $colorName = str_replace(['caret-'], '', $this->value);
        $color = $colors[$colorName] ?? '';

        if ($color) {
            if ($this->opacity !== null) {
                return "rgb({$color['rgb']} / {$this->getOpacityValue()})";
            }

            return $color['hex'];
        }

        return '';
    }

    private function getOpacityValue(): string
    {
        if ($this->opacity !== null) {
            $opacityInt = intval($this->opacity);
            if ($opacityInt % 5 === 0 && $opacityInt >= 0 && $opacityInt <= 100) {
                return ($opacityInt === 100) ? '1' : rtrim(sprintf('%.2f', $opacityInt / 100), '0');
            }
        }

        return '';
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_merge(array_keys($this->getColors()), ['inherit', 'current', 'transparent']);

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        return preg_match('/^(#[0-9A-Fa-f]{3,8}|rgb\(.*\)|rgba\(.*\)|hsl\(.*\)|hsla\(.*\))$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^caret-((?:\[.+\]|inherit|current|transparent|black|white|slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)(?:-\d{1,3})?(?:\/[0-9]+)?)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            $opacity = null;

            if (strpos($value, '/') !== false) {
                [$color, $opacity] = explode('/', $value);
                $value = $color;
            }

            return new self($value, $isArbitrary, $opacity);
        }

        return null;
    }
}
