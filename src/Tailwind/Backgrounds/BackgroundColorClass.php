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
        if (!$this->isValidValue()) {
            return '';
        }

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $colorValue = $this->getColorValue();

        if ($this->isArbitrary) {
            return ".bg-{$classValue}{--tw-bg-opacity:1;background-color:{$colorValue};}";
        }

        if ($this->opacity !== null) {
            $classValue .= "\\/{$this->opacity}";
            $opacityValue = $this->getOpacityValue();
            return ".bg-{$classValue}{background-color:rgb({$colorValue} / {$opacityValue});}";
        }

        $specialColors = ['inherit', 'current', 'transparent'];
        if (in_array($this->value, $specialColors)) {
            if ($this->value === 'current') {
                return ".bg-{$classValue}{background-color:currentColor;}";
            }
            return ".bg-{$classValue}{background-color:{$colorValue};}";
        }

        return ".bg-{$classValue}{--tw-bg-opacity:1;background-color:rgb({$colorValue} / var(--tw-bg-opacity));}";
    }

    private function getColorValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        $specialColors = ['inherit', 'current', 'transparent'];
        if (in_array($this->value, $specialColors)) {
            return $this->value;
        }

        return $this->getColors()[$this->value] ?? '';
    }

    private function getOpacityValue(): string
    {
        if ($this->opacity !== null) {
            return number_format(intval($this->opacity) / 100, 2);
        }
        return '1';
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
        if (preg_match('/^bg-((?:\[.+\]|inherit|current|transparent|black|white|slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)(?:-\d{1,3})?(?:\/[0-9.]+)?)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            $opacity = null;
            
            if (strpos($value, '/') !== false) {
                list($color, $opacity) = explode('/', $value);
                $value = $color;
            }
            
            return new self($value, $isArbitrary, $opacity);
        }
        return null;
    }
}