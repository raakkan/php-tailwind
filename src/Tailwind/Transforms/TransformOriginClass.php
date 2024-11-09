<?php

namespace Raakkan\PhpTailwind\Tailwind\Transforms;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class TransformOriginClass extends AbstractTailwindClass
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

        $originValue = $this->getOriginValue();
        $classValue = $this->value;

        if ($this->isArbitrary) {
            $classValue = "\\[{$this->escapeArbitraryValue($this->value)}\\]";
            $originValue = $this->formatArbitraryValue($originValue);
        }

        return ".origin-{$classValue}{transform-origin:{$originValue};}";
    }

    private function getOriginValue(): string
    {
        $origins = [
            'center' => 'center',
            'top' => 'top',
            'top-right' => 'top right',
            'right' => 'right',
            'bottom-right' => 'bottom right',
            'bottom' => 'bottom',
            'bottom-left' => 'bottom left',
            'left' => 'left',
            'top-left' => 'top left',
        ];

        return $this->isArbitrary ? $this->value : ($origins[$this->value] ?? 'center');
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = ['center', 'top', 'top-right', 'right', 'bottom-right', 'bottom', 'bottom-left', 'left', 'top-left'];

        return in_array($this->value, $validValues);
    }

    private function formatArbitraryValue(string $value): string
    {
        // Replace underscores with spaces, except within parentheses
        $formatted = preg_replace_callback('/\([^)]+\)|\S+/', function ($match) {
            return str_replace('_', ' ', $match[0]);
        }, $value);

        // Remove backslashes from escaped characters
        return stripslashes($formatted);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^origin-(\[.+\]|center|top|top-right|right|bottom-right|bottom|bottom-left|left|top-left)$/', $class, $matches)) {
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
