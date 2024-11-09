<?php

namespace Raakkan\PhpTailwind\Tailwind\Backgrounds;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class GradientColorStopClass extends AbstractTailwindClass
{
    private $position;

    private $isArbitrary;

    private $opacity;

    public function __construct(string $value, string $position, bool $isArbitrary = false, ?string $opacity = null)
    {
        parent::__construct($value);
        $this->position = $position;
        $this->isArbitrary = $isArbitrary;
        $this->opacity = $opacity;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $prefix = $this->position;
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $colorValue = $this->getColorValue();

        $css = ".{$prefix}-{$classValue}{";

        if ($prefix === 'from') {
            $css .= "--tw-gradient-from:{$colorValue['hex']} var(--tw-gradient-from-position);";
            $css .= "--tw-gradient-to:rgb({$colorValue['rgb']} / 0) var(--tw-gradient-to-position);";
            $css .= '--tw-gradient-stops:var(--tw-gradient-from),var(--tw-gradient-to);';
        } elseif ($prefix === 'via') {
            $css .= "--tw-gradient-to:rgb({$colorValue['rgb']} / 0) var(--tw-gradient-to-position);";
            $css .= "--tw-gradient-stops:var(--tw-gradient-from),{$colorValue['hex']} var(--tw-gradient-via-position),var(--tw-gradient-to);";
        } elseif ($prefix === 'to') {
            $css .= "--tw-gradient-to:{$colorValue['hex']} var(--tw-gradient-to-position);";
        }

        $css .= '}';

        return $css;
    }

    private function getColorValue(): string|array
    {
        if ($this->isArbitrary) {
            $value = trim($this->value, '[]');

            if (preg_match('/^#([A-Fa-f0-9]{3}){1,2}$/', $value)) {

                if (strlen($value) === 4) {
                    $value = '#'.$value[1].$value[1].$value[2].$value[2].$value[3].$value[3];
                }

                $rgb = sscanf($value, '#%02x%02x%02x');

                return [
                    'hex' => $value,
                    'rgb' => implode(' ', $rgb),
                ];
            }
        }

        $specialColors = ['inherit', 'current', 'transparent'];
        if (in_array($this->value, $specialColors)) {
            $hex = $this->value == 'current' ? 'currentColor' : $this->value;
            $rgb = $this->value == 'transparent' ? '0 0 0' : '255 255 255';

            return [
                'hex' => $hex,
                'rgb' => $rgb,
            ];
        }

        $value = str_replace(['from-', 'to-', 'via-'], '', $this->value);

        return $this->getColors()[$value] ?? '';
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
        if (preg_match('/^(from|via|to)-((?:\[.+\]|inherit|current|transparent|black|white|slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)(?:-\d{1,3})?(?:\/[0-9.]+)?)$/', $class, $matches)) {
            $position = $matches[1];
            $value = $matches[2];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            $opacity = null;

            if (strpos($value, '/') !== false) {
                [$color, $opacity] = explode('/', $value);
                $value = $color;
            }

            return new self($value, $position, $isArbitrary, $opacity);
        }

        return null;
    }
}
