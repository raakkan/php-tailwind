<?php

namespace Raakkan\PhpTailwind\Tailwind\Layout;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class AspectRatioClass extends AbstractTailwindClass
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
        $classValue = str_replace('/', '\/', $classValue);
        $value = $this->isArbitrary ? $this->value : $this->getPresetValue($this->value);

        return ".aspect-{$classValue}{aspect-ratio:{$value};}";
    }

    private function isValidValue(): bool
    {
        $validPresets = ['auto', 'square', 'video'];

        if (in_array($this->value, $validPresets)) {
            return true;
        }

        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        return false;
    }

    private function isValidArbitraryValue(): bool
    {
        // Check for valid fractions or decimal numbers
        if (preg_match('/^\d+(\.\d+)?\/\d+(\.\d+)?$/', $this->value)) {
            return true;
        }

        // Check for single decimal number
        if (is_numeric($this->value)) {
            return true;
        }

        return false;
    }

    private function getPresetValue(string $preset): string
    {
        switch ($preset) {
            case 'auto':
                return 'auto';
            case 'square':
                return '1/1';
            case 'video':
                return '16/9';
            default:
                return $preset;
        }
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^aspect-(\[.+\]|auto|square|video)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = $value[0] === '[';
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }

            return new self($value, $isArbitrary);
        }

        return null;
    }
}
