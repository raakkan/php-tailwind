<?php

namespace Raakkan\PhpTailwind\Tailwind\Layout;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class ColumnsClass extends AbstractTailwindClass
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
        $value = $this->isArbitrary ? $this->value : $this->getPresetValue($this->value);

        return ".columns-{$classValue}{columns:{$value};}";
    }

    private function isValidValue(): bool
    {
        $validPresets = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', 'auto', '3xs', '2xs', 'xs', 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'];

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
        // Check for valid numeric values or rem values
        return is_numeric($this->value) || preg_match('/^\d+(\.\d+)?rem$/', $this->value);
    }

    private function getPresetValue(string $preset): string
    {
        $presetValues = [
            '3xs' => '16rem',
            '2xs' => '18rem',
            'xs' => '20rem',
            'sm' => '24rem',
            'md' => '28rem',
            'lg' => '32rem',
            'xl' => '36rem',
            '2xl' => '42rem',
            '3xl' => '48rem',
            '4xl' => '56rem',
            '5xl' => '64rem',
            '6xl' => '72rem',
            '7xl' => '80rem',
        ];

        return $presetValues[$preset] ?? $preset;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^columns-(\[.+\]|auto|[1-9]|1[0-2]|3xs|2xs|xs|sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)$/', $class, $matches)) {
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
