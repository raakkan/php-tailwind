<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class DropShadowClass extends AbstractTailwindClass
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

        $dropShadowValue = $this->getDropShadowValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        
        return ".drop-shadow-{$classValue}{--tw-drop-shadow:{$dropShadowValue};filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);}";
    }

    private function getDropShadowValue(): string
    {
        $dropShadows = [
            'sm' => 'drop-shadow(0 1px 1px rgb(0 0 0 / 0.05))',
            'DEFAULT' => 'drop-shadow(0 1px 2px rgb(0 0 0 / 0.1)) drop-shadow(0 1px 1px rgb(0 0 0 / 0.06))',
            'md' => 'drop-shadow(0 4px 3px rgb(0 0 0 / 0.07)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.06))',
            'lg' => 'drop-shadow(0 10px 8px rgb(0 0 0 / 0.04)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.1))',
            'xl' => 'drop-shadow(0 20px 13px rgb(0 0 0 / 0.03)) drop-shadow(0 8px 5px rgb(0 0 0 / 0.08))',
            '2xl' => 'drop-shadow(0 25px 25px rgb(0 0 0 / 0.15))',
            'none' => 'drop-shadow(0 0 #0000)',
        ];

        return $this->isArbitrary ? "drop-shadow({$this->value})" : ($dropShadows[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['sm', 'DEFAULT', 'md', 'lg', 'xl', '2xl', 'none'];
        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if ($class === 'drop-shadow') {
            return new self('DEFAULT', false);
        }
        if (preg_match('/^drop-shadow-(\[.+\]|sm|md|lg|xl|2xl|none)$/', $class, $matches)) {
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