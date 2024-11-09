<?php

namespace Raakkan\PhpTailwind\Tailwind\Borders;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class RingColorClass extends AbstractTailwindClass
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

        $css = ".ring-{$classValue}".($this->opacity !== null ? "\\/{$this->opacity}" : '').'{';

        $specialColors = ['inherit', 'current', 'transparent'];
        if (! in_array($this->value, $specialColors) && $this->opacity === null) {
            $css .= '--tw-ring-opacity:1;';
        }

        $css .= "--tw-ring-color:{$colorValue};";

        $css .= '}';

        return $css;
    }

    private function getColorValue(): string
    {
        if ($this->isArbitrary) {
            $value = trim($this->value, '[]');

            if (preg_match('/^#([A-Fa-f0-9]{3}){1,2}$/', $value)) {
                $rgb = $this->hexToRgb($value);

                return "rgb({$rgb} / var(--tw-ring-opacity))";
            }

            if (preg_match('/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/', $value, $matches)) {
                $rgb = "{$matches[1]} {$matches[2]} {$matches[3]}";

                return "rgb($rgb / var(--tw-ring-opacity))";
            }

            if (preg_match('/^hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)$/', $value, $matches)) {
                return "{$value} / var(--tw-ring-opacity)";
            }

            return $value;
        }

        $specialColors = ['inherit', 'current', 'transparent'];
        if (in_array($this->value, $specialColors)) {
            if ($this->value === 'current') {
                return 'currentColor';
            }

            return $this->value;
        }

        $colors = $this->getColors();
        $colorName = str_replace(['ring-'], '', $this->value);
        $color = $colors[$colorName] ?? '';

        if ($color) {
            if ($this->opacity !== null) {
                return "rgb({$color['rgb']} / {$this->getOpacityValue()})";
            }

            return "rgb({$color['rgb']} / var(--tw-ring-opacity))";
        }

        return '';
    }

    private function hexToRgb($hex): string
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) == 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "{$r} {$g} {$b}";
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

        // Allow any valid CSS color value
        return preg_match('/^(#[0-9A-Fa-f]{3,8}|rgb\(.*\)|rgba\(.*\)|hsl\(.*\)|hsla\(.*\))$/', $value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^ring-((?:\[.+\]|inherit|current|transparent|black|white|slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)(?:-\d{1,3})?(?:\/[0-9.]+)?)$/', $class, $matches)) {
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
