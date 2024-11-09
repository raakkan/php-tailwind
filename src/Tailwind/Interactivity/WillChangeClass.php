<?php

namespace Raakkan\PhpTailwind\Tailwind\Interactivity;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class WillChangeClass extends AbstractTailwindClass
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

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $willChangeValue = $this->getWillChangeValue();

        return ".will-change-{$classValue}{will-change:{$willChangeValue};}";
    }

    private function getWillChangeValue(): string
    {
        if ($this->isArbitrary) {
            return str_replace('_', ' ', $this->value);
        }

        $willChangeValues = $this->getWillChangeValues();

        return $willChangeValues[$this->value] ?? '';
    }

    private function getWillChangeValues(): array
    {
        return [
            'auto' => 'auto',
            'scroll' => 'scroll-position',
            'contents' => 'contents',
            'transform' => 'transform',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = array_keys($this->getWillChangeValues());

        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^will-change-(\[.+\]|[a-z-]+)$/', $class, $matches)) {
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
