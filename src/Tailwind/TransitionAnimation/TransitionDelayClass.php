<?php

namespace Raakkan\PhpTailwind\Tailwind\TransitionAnimation;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class TransitionDelayClass extends AbstractTailwindClass
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

        $delayValue = $this->getDelayValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;

        return ".delay-{$classValue}{transition-delay:{$delayValue};}";
    }

    private function getDelayValue(): string
    {
        $delays = [
            '0' => '0s',
            '75' => '75ms',
            '100' => '100ms',
            '150' => '150ms',
            '200' => '200ms',
            '300' => '300ms',
            '500' => '500ms',
            '700' => '700ms',
            '1000' => '1000ms',
        ];

        return $this->isArbitrary ? $this->value : ($delays[$this->value] ?? '');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true;
        }

        $validValues = ['0', '75', '100', '150', '200', '300', '500', '700', '1000'];
        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^delay-(0|75|100|150|200|300|500|700|1000|\[.+\])$/', $class, $matches)) {
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