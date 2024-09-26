<?php

namespace Raakkan\PhpTailwind\Spacing;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class MarginClass extends AbstractTailwindClass
{
    private $direction;
    private $isNegative;
    private $isAuto;

    public function __construct(string $value, string $direction = '', bool $isNegative = false, bool $isAuto = false)
    {
        parent::__construct($value);
        $this->direction = $direction;
        $this->isNegative = $isNegative;
        $this->isAuto = $isAuto;
    }

    public function toCss(): string
    {
        if ($this->isAuto) {
            return $this->getAutoMargin();
        }

        $value = SpacingValueCalculator::calculate($this->value, $this->isNegative);
        $prefix = $this->isNegative ? '-' : '';
        
        switch ($this->direction) {
            case 'x':
                return <<<CSS
.{$prefix}mx-{$this->value} {
    margin-left: {$value};
    margin-right: {$value};
}
CSS;
            case 'y':
                return <<<CSS
.{$prefix}my-{$this->value} {
    margin-top: {$value};
    margin-bottom: {$value};
}
CSS;
            case 't':
                return <<<CSS
.{$prefix}mt-{$this->value} {
    margin-top: {$value};
}
CSS;
            case 'r':
                return <<<CSS
.{$prefix}mr-{$this->value} {
    margin-right: {$value};
}
CSS;
            case 'b':
                return <<<CSS
.{$prefix}mb-{$this->value} {
    margin-bottom: {$value};
}
CSS;
            case 'l':
                return <<<CSS
.{$prefix}ml-{$this->value} {
    margin-left: {$value};
}
CSS;
            case 'e':
                return <<<CSS
.{$prefix}me-{$this->value} {
    margin-inline-end: {$value};
}
CSS;
            case 's':
                return <<<CSS
.{$prefix}ms-{$this->value} {
    margin-inline-start: {$value};
}
CSS;
            default:
                return <<<CSS
.{$prefix}m-{$this->value} {
    margin: {$value};
}
CSS;
        }
    }

    private function getAutoMargin(): string
    {
        switch ($this->direction) {
            case 'x':
                return <<<CSS
.mx-auto {
    margin-left: auto;
    margin-right: auto;
}
CSS;
            case 'y':
                return <<<CSS
.my-auto {
    margin-top: auto;
    margin-bottom: auto;
}
CSS;
            case 't':
                return <<<CSS
.mt-auto {
    margin-top: auto;
}
CSS;
            case 'r':
                return <<<CSS
.mr-auto {
    margin-right: auto;
}
CSS;
            case 'b':
                return <<<CSS
.mb-auto {
    margin-bottom: auto;
}
CSS;
            case 'l':
                return <<<CSS
.ml-auto {
    margin-left: auto;
}
CSS;
            case 'e':
                return <<<CSS
.me-auto {
    margin-inline-end: auto;
}
CSS;
            case 's':
                return <<<CSS
.ms-auto {
    margin-inline-start: auto;
}
CSS;
            default:
                return <<<CSS
.m-auto {
    margin: auto;
}
CSS;
        }
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^(-?)(m)(x|y|t|r|b|l|e|s)?-(.+)$/', $class, $matches)) {
            [, $negative, , $direction, $value] = $matches;
            $isAuto = $value === 'auto';
            return new self($value, $direction ?: '', $negative === '-', $isAuto);
        }
        return null;
    }
}