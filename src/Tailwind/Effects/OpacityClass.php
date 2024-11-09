<?php

namespace Raakkan\PhpTailwind\Tailwind\Effects;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class OpacityClass extends AbstractTailwindClass
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

        $opacityValue = $this->getOpacityValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;

        return ".opacity-{$classValue}{opacity:{$opacityValue};}";
    }

    private function getOpacityValue(): string
    {
        $opacities = [
            '0' => '0',
            '5' => '0.05',
            '10' => '0.1',
            '15' => '0.15',
            '20' => '0.2',
            '25' => '0.25',
            '30' => '0.3',
            '35' => '0.35',
            '40' => '0.4',
            '45' => '0.45',
            '50' => '0.5',
            '55' => '0.55',
            '60' => '0.6',
            '65' => '0.65',
            '70' => '0.7',
            '75' => '0.75',
            '80' => '0.8',
            '85' => '0.85',
            '90' => '0.9',
            '95' => '0.95',
            '100' => '1',
        ];

        return $this->isArbitrary ? $this->value : ($opacities[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['0', '5', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '60', '65', '70', '75', '80', '85', '90', '95', '100'];

        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^opacity-(\[.+\]|0|5|10|15|20|25|30|35|40|45|50|55|60|65|70|75|80|85|90|95|100)$/', $class, $matches)) {
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
