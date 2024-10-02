<?php

namespace Raakkan\PhpTailwind\Tailwind\Borders;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class DivideWidthClass extends AbstractTailwindClass
{
    private $isArbitrary;
    private $direction;
    private $isReverse;

    public function __construct(string $value, string $direction = '', bool $isArbitrary = false, bool $isReverse = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
        $this->direction = $direction;
        $this->isReverse = $isReverse;
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $classValue = $this->isArbitrary ? "-\\[{$this->escapeArbitraryValue($this->value)}\\]" : ($this->value === 'DEFAULT' ? '' : "-{$this->value}");
        $divideValue = $this->getDivideValue();

        $directionPrefix = $this->getDirectionPrefix();
        $properties = $this->getDivideProperties();

        $reverseModifier = $this->isReverse ? '-reverse' : '';
        $css = ".divide-{$directionPrefix}{$classValue}{$reverseModifier} > :not([hidden]) ~ :not([hidden]) {";

        $css .= "--tw-divide-{$this->direction}-reverse: " . ($this->isReverse ? '1' : '0') . ";";

        if (!$this->isReverse || $this->value !== 'DEFAULT') {
            foreach ($properties as $property => $calculation) {
                $css .= "{$property}: calc({$divideValue} * {$calculation});";
            }
        }

        $css .= "}";

        return $css;
    }

    private function getDivideValue(): string
    {
        if ($this->isArbitrary) {
            return $this->value;
        }

        $divideWidths = [
            '0' => '0px',
            '2' => '2px',
            '4' => '4px',
            '8' => '8px',
            'DEFAULT' => '1px',
        ];

        return $divideWidths[$this->value] ?? $this->value;
    }

    private function getDirectionPrefix(): string
    {
        return $this->direction;
    }

    private function getDivideProperties(): array
    {
        $properties = [
            'x' => [
                'border-right-width' => 'var(--tw-divide-x-reverse)',
                'border-left-width' => 'calc(1 - var(--tw-divide-x-reverse))'
            ],
            'y' => [
                'border-bottom-width' => 'var(--tw-divide-y-reverse)',
                'border-top-width' => 'calc(1 - var(--tw-divide-y-reverse))'
            ],
        ];

        return $properties[$this->direction] ?? [];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue();
        }

        $validValues = ['0', '2', '4', '8', 'DEFAULT'];
        return in_array($this->value, $validValues);
    }

    private function isValidArbitraryValue(): bool
    {
        $value = trim($this->value, '[]');
        return preg_match('/^[a-zA-Z0-9-_.%()]+$/', $value) === 1;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^divide-(x|y)(-reverse)?(-(.+))?$/', $class, $matches)) {
            $direction = $matches[1];
            $isReverse = !empty($matches[2]);
            $value = $matches[4] ?? 'DEFAULT';
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }
            
            return new self($value, $direction, $isArbitrary, $isReverse);
        }
        return null;
    }
}