<?php

namespace Raakkan\PhpTailwind\Tailwind\Interactivity;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class CursorClass extends AbstractTailwindClass
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

        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        $cursorValue = $this->getCursorValue();
        
        return ".cursor-{$classValue}{cursor:{$cursorValue};}";
    }

    private function getCursorValue(): string
    {
        if ($this->isArbitrary) {
            return str_replace('_', ' ', $this->value);
        }

        $cursors = $this->getCursorValues();

        return $cursors[$this->value] ?? '';
    }

    private function getCursorValues(): array
    {
        return [
            'auto' => 'auto',
            'default' => 'default',
            'pointer' => 'pointer',
            'wait' => 'wait',
            'text' => 'text',
            'move' => 'move',
            'help' => 'help',
            'not-allowed' => 'not-allowed',
            'none' => 'none',
            'context-menu' => 'context-menu',
            'progress' => 'progress',
            'cell' => 'cell',
            'crosshair' => 'crosshair',
            'vertical-text' => 'vertical-text',
            'alias' => 'alias',
            'copy' => 'copy',
            'no-drop' => 'no-drop',
            'grab' => 'grab',
            'grabbing' => 'grabbing',
            'all-scroll' => 'all-scroll',
            'col-resize' => 'col-resize',
            'row-resize' => 'row-resize',
            'n-resize' => 'n-resize',
            'e-resize' => 'e-resize',
            's-resize' => 's-resize',
            'w-resize' => 'w-resize',
            'ne-resize' => 'ne-resize',
            'nw-resize' => 'nw-resize',
            'se-resize' => 'se-resize',
            'sw-resize' => 'sw-resize',
            'ew-resize' => 'ew-resize',
            'ns-resize' => 'ns-resize',
            'nesw-resize' => 'nesw-resize',
            'nwse-resize' => 'nwse-resize',
            'zoom-in' => 'zoom-in',
            'zoom-out' => 'zoom-out',
        ];
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true; // Accept all arbitrary values
        }

        $validValues = array_keys($this->getCursorValues());
        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^cursor-(\[.+\]|[a-z-]+)$/', $class, $matches)) {
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