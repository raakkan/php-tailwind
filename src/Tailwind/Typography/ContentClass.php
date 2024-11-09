<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class ContentClass extends AbstractTailwindClass
{
    private $isArbitrary;

    private $pseudoElement;

    public function __construct(string $value, string $pseudoElement, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->pseudoElement = $pseudoElement;
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $contentValue = $this->getContentValue();

        $css = ".content-{$classValue} {";
        $css .= "--tw-content: {$contentValue};";
        $css .= 'content: var(--tw-content);';
        $css .= '}';

        $css .= ".{$this->pseudoElement}\\:content-{$classValue}::{$this->pseudoElement} {";
        $css .= "--tw-content: {$contentValue};";
        $css .= 'content: var(--tw-content);';
        $css .= '}';

        return $css;
    }

    private function getContentValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->getContentValues()[$this->value];
    }

    private function getContentValues(): array
    {
        return [
            'none' => 'none',
            'empty' => '""',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = array_keys($this->getContentValues());

        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        // Allow any string value for arbitrary content
        return true;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(before|after):content-((?:\[.+\]|none|empty))$/', $class, $matches)) {
            $pseudoElement = $matches[1];
            $value = $matches[2];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            return new self($value, $pseudoElement, $isArbitrary);
        }

        return null;
    }

    protected function escapeArbitraryValue(string $value): string
    {
        // Remove square brackets
        $value = trim($value, '[]');

        // Convert Unicode characters to their hex representation
        $value = preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($match) {
            return sprintf('\\%X', mb_ord($match[0]));
        }, $value);

        // Escape special characters
        $value = preg_replace('/([^a-zA-Z0-9])/', '\\\\$1', $value);

        return $value;
    }
}
