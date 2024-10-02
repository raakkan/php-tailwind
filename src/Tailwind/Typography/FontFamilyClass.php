<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class FontFamilyClass extends AbstractTailwindClass
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

        $classValue = $this->value;
        $cssValue = $this->calculateValue();

        if ($this->isArbitrary) {
            $escapedClassValue = '\['. $this->escapeArbitraryValue($classValue) . '\]';
        } else {
            $escapedClassValue = $classValue;
        }

        return ".font-{$escapedClassValue}{font-family:{$cssValue};}";
    }

    private function isValidValue(): bool
    {
        $validValues = ['sans', 'serif', 'mono'];

        if (in_array($this->value, $validValues)) {
            return true;
        }

        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue($this->value);
        }

        return false;
    }

    private function calculateValue(): string
    {
        $fontFamilies = [
            'sans' => 'ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
            'serif' => 'ui-serif, Georgia, Cambria, "Times New Roman", Times, serif',
            'mono' => 'ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
        ];

        if (isset($fontFamilies[$this->value])) {
            return $fontFamilies[$this->value];
        }

        if ($this->isArbitrary) {
            return $this->value;
        }

        return $this->value;
    }

    private function isValidArbitraryValue($value): bool
    {
        // Allow any non-empty string for arbitrary font family values
        return !empty($value);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^font-(.+)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = substr($value, 1, -1); // Remove brackets
            }
            return new self($value, $isArbitrary);
        }
        return null;
    }
}