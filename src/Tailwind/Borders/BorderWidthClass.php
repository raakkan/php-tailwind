<?php

namespace Raakkan\PhpTailwind\Tailwind\Borders;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BorderWidthClass extends AbstractTailwindClass
{
    private $isArbitrary;

    private $side;

    public function __construct(string $value, string $side = '', bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
        $this->side = $side;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $borderValue = $this->getBorderValue();

        $sidePrefix = $this->getSidePrefix();
        $properties = $this->getBorderProperties();

        // Update this condition to handle 'border' and 'border-{side}' cases
        if ($this->value === 'DEFAULT' || $this->value === '') {
            $css = ".border{$sidePrefix}{";
        } else {
            $css = ".border{$sidePrefix}-{$classValue}{";
        }

        foreach ($properties as $property) {
            $css .= "{$property}:{$borderValue};";
        }
        $css .= '}';

        return $css;
    }

    private function getBorderValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        $borderWidths = [
            '0' => '0px',
            '2' => '2px',
            '4' => '4px',
            '8' => '8px',
            'DEFAULT' => '1px',
            '' => '1px', // Add this line to handle 'border-{side}' cases
        ];

        return $borderWidths[$this->value] ?? $this->value;
    }

    private function getSidePrefix(): string
    {
        $sidePrefixes = [
            't' => '-t',
            'r' => '-r',
            'b' => '-b',
            'l' => '-l',
            'x' => '-x',
            'y' => '-y',
            's' => '-s',
            'e' => '-e',
        ];

        return $sidePrefixes[$this->side] ?? '';
    }

    private function getBorderProperties(): array
    {
        $sideProperties = [
            't' => ['border-top-width'],
            'r' => ['border-right-width'],
            'b' => ['border-bottom-width'],
            'l' => ['border-left-width'],
            'x' => ['border-left-width', 'border-right-width'],
            'y' => ['border-top-width', 'border-bottom-width'],
            's' => ['border-inline-start-width'],
            'e' => ['border-inline-end-width'],
        ];

        return $sideProperties[$this->side] ?? ['border-width'];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        // Add empty string to valid values for 'border-{side}' cases
        $validValues = ['0', '2', '4', '8', 'DEFAULT', ''];

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        $validUnits = ['px', 'em', 'rem', '%', 'vw', 'vh'];
        $pattern = '/^(-?\d*\.?\d+)('.implode('|', $validUnits).')$/';

        return preg_match($pattern, $value) || preg_match('/^(calc|clamp|min|max)\(.*\)$/', $value);
    }

    public static function parse(string $class): ?self
    {
        // Match exact 'border' class first
        if ($class === 'border') {
            return new self('DEFAULT', '', false);
        }

        // Match border width patterns: border-{side?}-{0|2|4|8}
        if (preg_match('/^border(-[trblxyes])?(?:-(?:0|2|4|8))?$/', $class, $matches)) {
            $side = ltrim($matches[1] ?? '', '-');
            $value = $matches[2] ?? '';

            return new self($value, $side, false);
        }

        // Match arbitrary border width: border-[10px]
        if (preg_match('/^border(?:-[trblxyes])?-(\[.+\])$/', $class, $matches)) {
            $side = ltrim($matches[1] ?? '', '-');
            $value = $matches[1];

            return new self($value, $side, true);
        }

        return null;
    }
}
