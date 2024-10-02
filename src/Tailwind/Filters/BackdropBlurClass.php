<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BackdropBlurClass extends AbstractTailwindClass
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

        $blurValue = $this->getBlurValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        
        return ".backdrop-blur-{$classValue}{--tw-backdrop-blur:blur({$blurValue});-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}";
    }

    private function getBlurValue(): string
    {
        $blurs = [
            'none' => '0',
            'sm' => '4px',
            'DEFAULT' => '8px',
            'md' => '12px',
            'lg' => '16px',
            'xl' => '24px',
            '2xl' => '40px',
            '3xl' => '64px',
        ];

        return $this->isArbitrary ? $this->value : ($blurs[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['none', 'sm', 'DEFAULT', 'md', 'lg', 'xl', '2xl', '3xl'];
        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if ($class === 'backdrop-blur') {
            return new self('DEFAULT', false);
        }
        if (preg_match('/^backdrop-blur-(\[.+\]|none|sm|md|lg|xl|2xl|3xl)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = trim($value, '[]');
            } elseif ($value === '') {
                $value = 'DEFAULT';
            }
            return new self($value, $isArbitrary);
        }
        return null;
    }
}