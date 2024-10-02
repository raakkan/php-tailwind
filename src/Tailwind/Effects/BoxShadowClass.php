<?php

namespace Raakkan\PhpTailwind\Tailwind\Effects;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BoxShadowClass extends AbstractTailwindClass
{
    private $isArbitrary;

    public function __construct(string $value, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $classValue = $this->value === 'DEFAULT' ? '' : '-' . ($this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value);
        $shadowValue = $this->getShadowValue();
        
        $css = ".shadow{$classValue}{";
        $css .= "--tw-shadow:{$shadowValue};";
        $css .= "--tw-shadow-colored:{$this->getColoredShadowValue($shadowValue)};";
        $css .= "box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);";
        $css .= "}";
        
        return $css;
    }

    private function getShadowValue(): string
    {
        $shadows = [
            'sm' => '0 1px 2px 0 rgb(0 0 0 / 0.05)',
            'DEFAULT' => '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
            'md' => '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
            'lg' => '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
            'xl' => '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
            '2xl' => '0 25px 50px -12px rgb(0 0 0 / 0.25)',
            'inner' => 'inset 0 2px 4px 0 rgb(0 0 0 / 0.05)',
            'none' => '0 0 #0000',
        ];

        return $this->isArbitrary ? $this->value : ($shadows[$this->value] ?? '');
    }

    private function getColoredShadowValue(string $shadowValue): string
    {
        if ($this->isArbitrary) {
            return $shadowValue;
        }
        return preg_replace('/rgb\([^)]+\)/', 'var(--tw-shadow-color)', $shadowValue);
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['sm', 'DEFAULT', 'md', 'lg', 'xl', '2xl', 'inner', 'none'];
        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if ($class === 'shadow') {
            return new self('DEFAULT', false);
        }
        if (preg_match('/^shadow-(\[.+\]|sm|md|lg|xl|2xl|inner|none)$/', $class, $matches)) {
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