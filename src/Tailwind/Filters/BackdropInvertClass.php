<?php

namespace Raakkan\PhpTailwind\Tailwind\Filters;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class BackdropInvertClass extends AbstractTailwindClass
{
    private $isArbitrary;
    private $isDefault;

    public function __construct(string $value, bool $isArbitrary = false, bool $isDefault = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
        $this->isDefault = $isDefault;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $invertValue = $this->getInvertValue();
        $classValue = $this->isDefault ? '' : ($this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value);
        $className = $this->isDefault ? 'backdrop-invert' : "backdrop-invert-{$classValue}";
        
        return ".{$className}{--tw-backdrop-invert:invert({$invertValue});-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);}";
    }

    private function getInvertValue(): string
    {
        $inverts = [
            '0' => '0',
            '' => '100%',
        ];

        return $this->isArbitrary ? $this->value : ($inverts[$this->value] ?? '100%');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary || $this->isDefault) {
            return true;
        }

        $validValues = ['0', ''];
        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if ($class === 'backdrop-invert') {
            return new self('', false, true);
        }

        if (preg_match('/^backdrop-invert(-(\[.+\]|0))?$/', $class, $matches)) {
            $value = isset($matches[2]) ? $matches[2] : '';
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }
            return new self($value, $isArbitrary);
        }
        return null;
    }
}