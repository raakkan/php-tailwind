<?php

namespace Raakkan\PhpTailwind;

use Raakkan\PhpTailwind\Spacing\MarginClass;
use Raakkan\PhpTailwind\Spacing\PaddingClass;
use Raakkan\PhpTailwind\Spacing\SpaceClass;

class TailwindParser
{
    private $classTypes = [
        MarginClass::class,
        PaddingClass::class,
        SpaceClass::class,
    ];

    public function parse(array $classes): string
    {
        $css = '';
        foreach ($classes as $class) {
            foreach ($this->classTypes as $classType) {
                if ($tailwindClass = $classType::parse($class)) {
                    $css .= $tailwindClass->toCss() . "\n";
                    break;
                }
            }
        }
        return $css;
    }
}