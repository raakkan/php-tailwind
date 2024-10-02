<?php

namespace Raakkan\PhpTailwind\Tailwind\Borders;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BorderRadiusClass extends AbstractTailwindClass
{
    private $side;
    private $isArbitrary;

    public function __construct(string $value, string $side = '', bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->side = $side;
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $value = $this->getCssValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        
        if ($this->value === 'DEFAULT') {
            $className = 'rounded';
        } else {
            $className = $this->side ? "rounded-{$this->side}-{$classValue}" : "rounded-{$classValue}";
        }
        
        $properties = $this->getRadiusProperties($value);
        
        return ".{$className}{{$properties}}";
    }

    private function getRadiusProperties(string $value): string
    {
        switch ($this->side) {
            case 't':
                return "border-top-left-radius:{$value};border-top-right-radius:{$value};";
            case 'r':
                return "border-top-right-radius:{$value};border-bottom-right-radius:{$value};";
            case 'b':
                return "border-bottom-right-radius:{$value};border-bottom-left-radius:{$value};";
            case 'l':
                return "border-top-left-radius:{$value};border-bottom-left-radius:{$value};";
            case 'tl':
                return "border-top-left-radius:{$value};";
            case 'tr':
                return "border-top-right-radius:{$value};";
            case 'br':
                return "border-bottom-right-radius:{$value};";
            case 'bl':
                return "border-bottom-left-radius:{$value};";
            case 's':
                return "border-start-start-radius:{$value};border-end-start-radius:{$value};";
            case 'e':
                return "border-start-end-radius:{$value};border-end-end-radius:{$value};";
            case 'ss':
                return "border-start-start-radius:{$value};";
            case 'se':
                return "border-start-end-radius:{$value};";
            case 'ee':
                return "border-end-end-radius:{$value};";
            case 'es':
                return "border-end-start-radius:{$value};";
            default:
                return "border-radius:{$value};";
        }
    }

    private function getCssValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        $sizeMap = [
            'DEFAULT' => '0.25rem',
            'none' => '0px',
            'sm' => '0.125rem',
            'md' => '0.375rem',
            'lg' => '0.5rem',
            'xl' => '0.75rem',
            '2xl' => '1rem',
            '3xl' => '1.5rem',
            'full' => '9999px',
        ];

        return $sizeMap[$this->value] ?? '0.25rem';
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = ['DEFAULT', 'none', 'sm', 'md', 'lg', 'xl', '2xl', '3xl', 'full'];
        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        $validUnits = ['px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax'];
        $pattern = '/^(-?\d*\.?\d+)(' . implode('|', $validUnits) . ')?$/';

        return preg_match($pattern, $value) || (strpos($value, 'calc(') === 0 && substr($value, -1) === ')');
    }

    public static function parse(string $class): ?self
    {
        if ($class === 'rounded') {
            return new self('DEFAULT', '', false);
        }
        if (preg_match('/^rounded(-([trblse]{1,2}))?(-(\[.+\]|[a-z0-9]+))?$/', $class, $matches)) {
            [, , $side, , $value] = $matches;
            $isArbitrary = $value && preg_match('/^\[.+\]$/', $value);
            
            return new self($value, $side, $isArbitrary);
        }
        return null;
    }
}
