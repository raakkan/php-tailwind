<?php

namespace Raakkan\PhpTailwind\Tailwind\Borders;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BorderColorClass extends AbstractTailwindClass
{
    private $side;
    private $isArbitrary;
    private $opacity;

    public function __construct(string $value, ?string $side = null, bool $isArbitrary = false, ?string $opacity = null)
    {
        parent::__construct($value);
        $this->side = $side;
        $this->isArbitrary = $isArbitrary;
        $this->opacity = $opacity;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $prefix = $this->side ? "border-{$this->side}" : "border";
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $colorValue = $this->getColorValue();
        
        $opacityValue = $this->opacity !== null ? $this->opacity : '1';
        $escapedOpacity = str_replace('.', '\\', $opacityValue);
        
        $css = ".{$prefix}-{$classValue}" . ($this->opacity !== null ? "\\/{$escapedOpacity}" : "") . "{";
        
        $css .= $this->getSideClass($colorValue);

        $css .= "}";
        return $css;
    }

    private function getSideClass(string $color): string
    {
        $specialColors = ['inherit', 'current', 'transparent'];
        if (in_array($this->value, $specialColors)) {
            if ($this->value === 'current') {
                return "border-color:currentColor;";
            }
            return "border-color:{$this->value};";
        }

        if ($this->opacity !== null) {
            return match ($this->side) {
                't' => "border-top-color:{$color};",
                'r' => "border-right-color:{$color};",
                'b' => "border-bottom-color:{$color};",
                'l' => "border-left-color:{$color};",
                'x' => "border-left-color:{$color};border-right-color:{$color};",
                'y' => "border-top-color:{$color};border-bottom-color:{$color};",
                's' => "border-inline-start-color:{$color};",
                'e' => "border-inline-end-color:{$color};",
                default => "border-color:{$color};",
            };
        }

        return match ($this->side) {
            't' => "--tw-border-opacity:1;border-top-color:{$color};",
            'r' => "--tw-border-opacity:1;border-right-color:{$color};",
            'b' => "--tw-border-opacity:1;border-bottom-color:{$color};",
            'l' => "--tw-border-opacity:1;border-left-color:{$color};",
            'x' => "--tw-border-opacity:1;border-left-color:{$color};border-right-color:{$color};",
            'y' => "--tw-border-opacity:1;border-top-color:{$color};border-bottom-color:{$color};",
            's' => "--tw-border-opacity:1;border-inline-start-color:{$color};",
            'e' => "--tw-border-opacity:1;border-inline-end-color:{$color};",
            default => "--tw-border-opacity:1;border-color:{$color};",
        };
    }

    private function getColorValue(): string
    {
        if ($this->isArbitrary) {
            $value = trim($this->value, '[]');

            if (preg_match('/^#([A-Fa-f0-9]{3}){1,2}$/', $value)) {
                
                if (strlen($value) === 4) {
                    $value = '#' . $value[1] . $value[1] . $value[2] . $value[2] . $value[3] . $value[3];
                }
                
                $rgb = sscanf($value, "#%02x%02x%02x");
                $rgb = implode(' ', $rgb);
                return "rgb($rgb / var(--tw-border-opacity))";
            }
            // Check for RGB or HSL color values
            if (preg_match('/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/', $value, $matches)) {
                $rgb = "{$matches[1]} {$matches[2]} {$matches[3]}";
                return "rgb($rgb / var(--tw-border-opacity))";
            }
            
            if (preg_match('/^hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)$/', $value, $matches)) {
                $h = $matches[1];
                $s = $matches[2];
                $l = $matches[3];
                return "hsl($h $s% $l% / var(--tw-border-opacity))";
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
        $colorName = str_replace(['border-'], '', $this->value);
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
        return 'var(--tw-border-opacity)';
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
        if (preg_match('/^border(?:-(x|y|t|r|b|l))?-((?:\[.+\]|inherit|current|transparent|black|white|slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)(?:-\d{1,3})?(?:\/[0-9.]+)?)$/', $class, $matches)) {
            $side = $matches[1] ?? null;
            $value = $matches[2];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            $opacity = null;
            
            if (strpos($value, '/') !== false) {
                list($color, $opacity) = explode('/', $value);
                $value = $color;
            }
            
            return new self($value, $side, $isArbitrary, $opacity);
        }
        return null;
    }
}