<?php

namespace Raakkan\PhpTailwind\Tailwind\TransitionAnimation;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class TransitionPropertyClass extends AbstractTailwindClass
{
    private $isArbitrary;

    public function __construct(string $value, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $propertyValue = $this->getPropertyValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;

        $css = ".transition-{$classValue}{transition-property:{$propertyValue};";

        if ($this->value !== 'none') {
            $css .= 'transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms;';
        }

        $css .= '}';

        return $css;
    }

    private function getPropertyValue(): string
    {
        $properties = [
            'none' => 'none',
            'all' => 'all',
            'DEFAULT' => 'color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter',
            'colors' => 'color,background-color,border-color,text-decoration-color,fill,stroke',
            'opacity' => 'opacity',
            'shadow' => 'box-shadow',
            'transform' => 'transform',
        ];

        return $this->isArbitrary ? $this->value : ($properties[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true;
        }

        $validValues = ['none', 'all', 'DEFAULT', 'colors', 'opacity', 'shadow', 'transform'];

        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if ($class === 'transition') {
            return new self('DEFAULT', false);
        }
        if (preg_match('/^transition-(none|all|colors|opacity|shadow|transform|\[.+\])$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }

            return new self($value, $isArbitrary);
        }

        return null;
    }
}
