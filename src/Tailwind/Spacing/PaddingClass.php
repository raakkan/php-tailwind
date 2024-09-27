<?php

namespace Raakkan\PhpTailwind\Tailwind\Spacing;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class PaddingClass extends AbstractTailwindClass
{
    private $direction;
    private $isArbitrary;

    public function __construct(string $value, string $direction = '', bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->direction = $direction;
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        $value = $this->isArbitrary ? $this->value : SpacingValueCalculator::calculate($this->value);
        $classValue = $this->isArbitrary ? "\\[{$this->value}\\]" : $this->value;
        
        switch ($this->direction) {
            case 'x':
                return <<<CSS
.px-{$classValue} {
    padding-left: {$value};
    padding-right: {$value};
}
CSS;
            case 'y':
                return <<<CSS
.py-{$classValue} {
    padding-top: {$value};
    padding-bottom: {$value};
}
CSS;
            case 't':
                return <<<CSS
.pt-{$classValue} {
    padding-top: {$value};
}
CSS;
            case 'r':
                return <<<CSS
.pr-{$classValue} {
    padding-right: {$value};
}
CSS;
            case 'b':
                return <<<CSS
.pb-{$classValue} {
    padding-bottom: {$value};
}
CSS;
            case 'l':
                return <<<CSS
.pl-{$classValue} {
    padding-left: {$value};
}
CSS;
            case 'e':
                return <<<CSS
.pe-{$classValue} {
    padding-inline-end: {$value};
}
CSS;
            case 's':
                return <<<CSS
.ps-{$classValue} {
    padding-inline-start: {$value};
}
CSS;
            default:
                return <<<CSS
.p-{$classValue} {
    padding: {$value};
}
CSS;
        }
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^p(x|y|t|r|b|l|e|s)?-((?:\[.+\]|\d+\/\d+|.+))$/', $class, $matches)) {
            $direction = $matches[1] ?? '';
            $value = $matches[2];
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            if ($isArbitrary) {
                $value = trim($value, '[]');
            } else {
                $value = str_replace('/', '\/', $value);
            }
            return new self($value, $direction, $isArbitrary);
        }
        return null;
    }
}