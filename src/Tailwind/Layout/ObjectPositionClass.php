<?php

namespace Raakkan\PhpTailwind\Tailwind\Layout;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class ObjectPositionClass extends AbstractTailwindClass
{
    private bool $isArbitrary;

    public function __construct(string $value, bool $isArbitrary)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^object-(\[.+\])$/', $class, $matches)) {
            return new self($matches[1], true);
        }

        $predefinedPositions = [
            'left-top', 'top', 'right-bottom', 'center', 'left', 'right', 'bottom',
            'top-right', 'top-left', 'bottom-right', 'bottom-left'
        ];

        if (in_array(substr($class, 7), $predefinedPositions)) {
            return new self(substr($class, 7), false);
        }

        return null;
    }

    public function toCss(): string
    {
        if ($this->isArbitrary) {
            $innerValue = substr($this->value, 1, -1);
            if ($this->isValidArbitraryValue($innerValue)) {
                $escapedSelector = '\[' . $this->escapeArbitraryValue($this->value) . '\]';
                return sprintf('.object-%s{object-position:%s;}', $escapedSelector, str_replace('_', ' ', $innerValue));
            }
            return '';
        }

        $positions = [
            'left-top' => 'left top',
            'top' => 'top',
            'right-bottom' => 'right bottom',
            'center' => 'center',
            'left' => 'left',
            'right' => 'right',
            'bottom' => 'bottom',
            'top-right' => 'top right',
            'top-left' => 'top left',
            'bottom-right' => 'bottom right',
            'bottom-left' => 'bottom left',
        ];

        if (isset($positions[$this->value])) {
            return sprintf('.object-%s{object-position:%s;}', $this->value, $positions[$this->value]);
        }

        return '';
    }

    private function isValidArbitraryValue(string $value): bool
    {
        $keywords = ['left', 'center', 'right', 'top', 'bottom'];
        $units = ['%', 'px', 'em', 'rem', 'vw', 'vh', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'ch'];
        $globalValues = ['inherit', 'initial', 'revert', 'revert-layer', 'unset', 'auto'];

        $parts = explode('_', $value);

        if (count($parts) > 4) {
            return false;
        }

        foreach ($parts as $part) {
            if (in_array($part, $keywords) || in_array($part, $globalValues)) {
                continue;
            }

            if (preg_match('/^-?\d*\.?\d+(' . implode('|', $units) . ')?$/', $part)) {
                continue;
            }

            return false;
        }

        return true;
    }
}