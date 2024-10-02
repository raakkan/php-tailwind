<?php

namespace Raakkan\PhpTailwind\Tailwind\Borders;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class DivideColorClass extends AbstractTailwindClass
{
    private $opacity;

    public function __construct(string $value, ?string $opacity = null)
    {
        parent::__construct($value);
        $this->opacity = $opacity;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $classValue = $this->isArbitrary() ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $colorValue = $this->getColorValue();
        
        $opacityValue = $this->opacity !== null ? $this->opacity : '1';
        $escapedOpacity = str_replace('.', '\\', $opacityValue);
        
        $css = ".divide-{$classValue}" . ($this->opacity !== null ? "\\/{$escapedOpacity}" : "") . " > :not([hidden]) ~ :not([hidden]){";
        
        $css .= $this->getDivideColorClass($colorValue);

        $css .= "}";
        return $css;
    }

    private function getDivideColorClass(string $color): string
    {
        $specialColors = ['inherit', 'current', 'transparent'];
        if (in_array($this->value, $specialColors)) {
            if ($this->value === 'current') {
                return "border-color:currentColor;";
            }
            return "border-color:{$this->value};";
        }

        if ($this->opacity !== null) {
            return "border-color:{$color};";
        }

        return "--tw-divide-opacity:1;border-color:{$color};";
    }

    private function getColorValue(): string
    {
        if ($this->isArbitrary()) {
            $value = trim($this->value, '[]');

            if (preg_match('/^#([A-Fa-f0-9]{3}){1,2}$/', $value)) {
                if (strlen($value) === 4) {
                    $value = '#' . $value[1] . $value[1] . $value[2] . $value[2] . $value[3] . $value[3];
                }
                
                $rgb = sscanf($value, "#%02x%02x%02x");
                $rgb = implode(' ', $rgb);
                return "rgb($rgb / var(--tw-divide-opacity))";
            }
            
            if (preg_match('/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/', $value, $matches)) {
                $rgb = "{$matches[1]} {$matches[2]} {$matches[3]}";
                return "rgb($rgb / var(--tw-divide-opacity))";
            }
            
            if (preg_match('/^hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)$/', $value, $matches)) {
                $h = $matches[1];
                $s = $matches[2];
                $l = $matches[3];
                return "hsl($h $s% $l% / var(--tw-divide-opacity))";
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
        $colorName = str_replace(['divide-'], '', $this->value);
        $color = $colors[$colorName] ?? '';
        
        if ($color) {
            $opacity = $this->getOpacityValue();
            return "rgb({$color['rgb']} / {$opacity})";
        }

        return $color;
    }

    private function getOpacityValue(): string
    {
        if ($this->opacity !== null) {
            $opacityInt = intval($this->opacity);
            if ($opacityInt % 5 === 0 && $opacityInt >= 0 && $opacityInt <= 100) {
                return ($opacityInt === 100) ? '1' : rtrim(sprintf('%.2f', $opacityInt / 100), '0');
            }
        }
        return 'var(--tw-divide-opacity)';
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary()) {
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

    private function isArbitrary(): bool
    {
        return preg_match('/^\[.+\]$/', $this->value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^divide-((?:\[.+\]|inherit|current|transparent|black|white|slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)(?:-\d{1,3})?(?:\/[0-9.]+)?)$/', $class, $matches)) {
            $value = $matches[1];
            $opacity = null;
            
            if (strpos($value, '/') !== false) {
                list($color, $opacity) = explode('/', $value);
                $value = $color;
            }
            
            return new self($value, $opacity);
        }
        return null;
    }
}