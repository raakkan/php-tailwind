<?php

namespace Raakkan\PhpTailwind\Tailwind\FlexGrid;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class FlexGrowClass extends AbstractTailwindClass
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

        $classValue = $this->value;
        $cssValue = $this->calculateValue();

        if ($this->isArbitrary) {
            $escapedClassValue = str_replace('/', '\/', $this->escapeArbitraryValue($classValue));

            return ".grow-\[{$escapedClassValue}\]{flex-grow:{$cssValue};}";
        } else {
            return $classValue === '' ? '.grow{flex-grow:1;}' : ".grow-{$classValue}{flex-grow:{$cssValue};}";
        }
    }

    private function isValidValue(): bool
    {
        if ($this->value === '') {
            return true;
        } // For 'grow'
        $validValues = ['0'];

        if (in_array($this->value, $validValues)) {
            return true;
        }

        if ($this->isArbitrary) {
            $trimmedValue = trim($this->value, '[]');

            return is_numeric($trimmedValue)
                || preg_match('/^\d+\/\d+$/', $trimmedValue)
                || strpos($trimmedValue, 'calc(') === 0;
        }

        return false;
    }

    private function calculateValue(): string
    {
        if ($this->isArbitrary) {
            return trim($this->value, '[]');
        }

        return $this->value === '' ? '1' : $this->value;
    }

    public static function parse(string $class): ?self
    {
        if ($class === 'grow') {
            return new self('', false);
        }
        if (preg_match('/^grow-(.+)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);

            return new self($value, $isArbitrary);
        }

        return null;
    }
}
