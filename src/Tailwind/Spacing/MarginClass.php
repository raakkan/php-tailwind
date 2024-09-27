<?php

namespace Raakkan\PhpTailwind\Tailwind\Spacing;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class MarginClass extends AbstractTailwindClass
{
    private $direction;
    private $isNegative;
    private $isAuto;
    private $isArbitrary;

    public function __construct(string $value, string $direction = '', bool $isNegative = false, bool $isAuto = false, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->direction = $direction;
        $this->isNegative = $isNegative;
        $this->isAuto = $isAuto;
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if ($this->isAuto) {
            return $this->getAutoMargin();
        }

        $value = $this->isArbitrary ? $this->value : SpacingValueCalculator::calculate($this->value, $this->isNegative);
        if ($this->isArbitrary && $this->isNegative) {
            $value = "-{$value}";
        }
        $prefix = $this->isNegative ? '-' : '';
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;
        
        // $value = $this->escapeCalc($value);
        
        switch ($this->direction) {
            case 'x':
                return <<<CSS
.{$prefix}mx-{$classValue} {
    margin-left: {$value};
    margin-right: {$value};
}
CSS;
            case 'y':
                return <<<CSS
.{$prefix}my-{$classValue} {
    margin-top: {$value};
    margin-bottom: {$value};
}
CSS;
            case 't':
                return <<<CSS
.{$prefix}mt-{$classValue} {
    margin-top: {$value};
}
CSS;
            case 'r':
                return <<<CSS
.{$prefix}mr-{$classValue} {
    margin-right: {$value};
}
CSS;
            case 'b':
                return <<<CSS
.{$prefix}mb-{$classValue} {
    margin-bottom: {$value};
}
CSS;
            case 'l':
                return <<<CSS
.{$prefix}ml-{$classValue} {
    margin-left: {$value};
}
CSS;
            case 'e':
                return <<<CSS
.{$prefix}me-{$classValue} {
    margin-inline-end: {$value};
}
CSS;
            case 's':
                return <<<CSS
.{$prefix}ms-{$classValue} {
    margin-inline-start: {$value};
}
CSS;
            default:
                return <<<CSS
.{$prefix}m-{$classValue} {
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
        if (preg_match('/^(-?)(m)(x|y|t|r|b|l|e|s)?-((?:\[.+\]|\d+\/\d+|.+))$/', $class, $matches)) {
            [, $negative, , $direction, $value] = $matches;
            $isAuto = $value === 'auto';
            $isArbitrary = preg_match('/^\[.+\]$/', $value);
            if ($isArbitrary) {
                $value = trim($value, '[]');
            } else if (!$isAuto) {
                $value = str_replace('/', '\/', $value);
            }
            return new self($value, $direction ?: '', $negative === '-', $isAuto, $isArbitrary);
        }
        return null;
    }
}