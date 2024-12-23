<?php

namespace Raakkan\PhpTailwind\Tailwind\Backgrounds;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BackgroundColorClass extends AbstractTailwindClass
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

        $css = ".bg-{$classValue}";
        if ($this->opacity !== null) {
            $css .= "\\/{$this->opacity}";
        }
        $css .= ' {';

        if ($this->opacity === null) {
            $css .= '--tw-bg-opacity: 1;';
        }
        $css .= "background-color: {$colorValue};}";

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
        $color = $colors[$this->value] ?? '';

        if ($color) {
            if ($this->opacity !== null) {
                return "rgb({$color['rgb']} / {$this->getOpacityValue()})";
            }

            return "rgb({$color['rgb']} / var(--tw-bg-opacity))";
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

        $validValues = array_keys($this->getColors());

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');

        // Allow any valid CSS color value
        return preg_match('/^(#[0-9A-Fa-f]{3,8}|rgb\(.*\)|rgba\(.*\)|hsl\(.*\)|hsla\(.*\))$/', $value);
    }

    public static function parse(string $class): ?self
    {
        // Match color patterns with optional opacity
        $pattern = '/^bg-('.
            '(?:\[#[0-9A-Fa-f]{3,8}\])|'.  // Arbitrary hex colors
            '(?:\[(?:rgb|hsl)a?\([^]]+\)\])|'.  // Arbitrary rgb/hsl colors
            '(?:inherit|current|transparent|black|white)|'.  // Special values and basic colors
            '(?:(?:slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)(?:-\d{1,3})?))'.  // Named colors
            '(?:\/([0-9.]+))?$/'; // Optional opacity

        if (preg_match($pattern, $class, $matches)) {
            $value = $matches[1];
            $opacity = $matches[2] ?? null;
            $isArbitrary = str_starts_with($value, '[');

            if ($isArbitrary) {
                $value = trim($value, '[]');
            }

            return new self($value, $isArbitrary, $opacity);
        }

        return null;
    }
}
