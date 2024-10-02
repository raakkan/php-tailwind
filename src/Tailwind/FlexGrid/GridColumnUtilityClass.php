<?php

namespace Raakkan\PhpTailwind\Tailwind\FlexGrid;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class GridColumnUtilityClass extends AbstractTailwindClass
{
    private $isSpan;
    private $isStart;
    private $isEnd;
    private $isArbitrary;

    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->isSpan = strpos($value, 'span-') === 0;
        $this->isStart = strpos($value, 'start-') === 0;
        $this->isEnd = strpos($value, 'end-') === 0;
        $this->isArbitrary = preg_match('/^\[.+\]$/', $value) || 
                             (($this->isStart || $this->isEnd) && strpos($value, '[') !== false);
    }

    public function toCss(): string
    {
        if (!$this->isValidValue()) {
            return '';
        }

        $property = $this->getProperty();
        $cssValue = $this->getCssValue();

        $escapedValue = $this->escapeValue($this->value);
        return ".col-{$escapedValue}{{$property}:{$cssValue};}";
    }

    private function isValidValue(): bool
    {
        $validValues = ['auto', 'span-full'];
        $validRanges = [
            'span' => range(1, 12),
            'start' => range(1, 13),
            'end' => range(1, 13)
        ];

        if (in_array($this->value, $validValues)) {
            return true;
        }

        if ($this->isSpan && in_array(substr($this->value, 5), $validRanges['span'])) {
            return true;
        }

        if (($this->isStart || $this->isEnd) && (substr($this->value, -4) === 'auto' || 
            in_array(substr($this->value, $this->isStart ? 6 : 4), $this->isStart ? $validRanges['start'] : $validRanges['end']))) {
            return true;
        }

        if ($this->isArbitrary) {
            return $this->isValidArbitraryValue($this->value);
        }

        return false;
    }

    private function getProperty(): string
    {
        if ($this->isSpan || $this->value === 'auto' || $this->value === 'span-full' || 
            ($this->isArbitrary && !$this->isStart && !$this->isEnd)) {
            return 'grid-column';
        }
        if ($this->isStart) {
            return 'grid-column-start';
        }
        if ($this->isEnd) {
            return 'grid-column-end';
        }
        return '';
    }

    private function getCssValue(): string
    {
        switch ($this->value) {
            case 'auto':
            case 'start-auto':
            case 'end-auto':
                return 'auto';
            case 'span-full':
                return '1 / -1';
            default:
                if ($this->isSpan) {
                    $span = substr($this->value, 5);
                    return "span {$span} / span {$span}";
                }
                if ($this->isStart || $this->isEnd) {
                    $value = substr($this->value, $this->isStart ? 6 : 4);
                    return $this->isArbitrary ? trim($value, '[]') : $value;
                }
                if ($this->isArbitrary) {
                    return str_replace('_', ' ', $this->decodeArbitraryValue(trim($this->value, '[]')));
                }
                return '';
        }
    }

    private function encodeArbitraryValue(string $value): string
    {
        $value = trim($value, '[]');
        $value = preg_replace('/[\/\(\)]/', '\\\\$0', $value);
        $value = str_replace(',', '\\2c ', $value);
        return '\[' . $value . '\]';
    }

    private function decodeArbitraryValue(string $value): string
    {
        return str_replace('\\2c', ',', $value);
    }

    private function isValidArbitraryValue($value): bool
    {
        $value = trim($value, '[]');
        return !empty($value) && trim($value) !== '';
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^col-(span-\d+|start-(\d+|\[.+\]|auto)|end-(\d+|\[.+\]|auto)|auto|span-full|\[.+\])$/', $class, $matches)) {
            return new self($matches[1]);
        }
        return null;
    }

    private function escapeValue(string $value): string
    {
        if ($this->isArbitrary) {
            if ($this->isStart || $this->isEnd) {
                $prefix = $this->isStart ? 'start-' : 'end-';
                $arbitraryPart = substr($value, strlen($prefix));
                return $prefix . $this->encodeArbitraryValue($arbitraryPart);
            }
            return $this->encodeArbitraryValue($value);
        }
        return $value;
    }
}