<?php

namespace Raakkan\PhpTailwind\Spacing;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class PaddingClass extends AbstractTailwindClass
{
    private $direction;

    public function __construct(string $value, string $direction = '')
    {
        parent::__construct($value);
        $this->direction = $direction;
    }

    public function toCss(): string
    {
        $value = SpacingValueCalculator::calculate($this->value);
        
        switch ($this->direction) {
            case 'x':
                return <<<CSS
.px-{$this->value} {
    padding-left: {$value};
    padding-right: {$value};
}
CSS;
            case 'y':
                return <<<CSS
.py-{$this->value} {
    padding-top: {$value};
    padding-bottom: {$value};
}
CSS;
            case 't':
                return <<<CSS
.pt-{$this->value} {
    padding-top: {$value};
}
CSS;
            case 'r':
                return <<<CSS
.pr-{$this->value} {
    padding-right: {$value};
}
CSS;
            case 'b':
                return <<<CSS
.pb-{$this->value} {
    padding-bottom: {$value};
}
CSS;
            case 'l':
                return <<<CSS
.pl-{$this->value} {
    padding-left: {$value};
}
CSS;
            case 'e':
                return <<<CSS
.pe-{$this->value} {
    padding-inline-end: {$value};
}
CSS;
            case 's':
                return <<<CSS
.ps-{$this->value} {
    padding-inline-start: {$value};
}
CSS;
            default:
                return <<<CSS
.p-{$this->value} {
    padding: {$value};
}
CSS;
        }
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(p)(x|y|t|r|b|l|e|s)?-(.+)$/', $class, $matches)) {
            [, , $direction, $value] = $matches;
            return new self($value, $direction ?: '');
        }
        return null;
    }
}