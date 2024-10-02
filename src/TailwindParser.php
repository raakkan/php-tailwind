<?php

namespace Raakkan\PhpTailwind;

use Raakkan\PhpTailwind\Tailwind\Spacing\MarginClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\PaddingClass;
use Raakkan\PhpTailwind\Tailwind\Spacing\SpaceClass;
use Raakkan\PhpTailwind\Tailwind\Layout\ObjectPositionClass;
use Raakkan\PhpTailwind\Tailwind\StaticClass;

class TailwindParser
{
    private $classTypes = [
        MarginClass::class,
        PaddingClass::class,
        SpaceClass::class,
        ObjectPositionClass::class,
        StaticClass::class,
    ];

    private $missingClassHandler;

    public function parse(array $classes): array
    {
        $css = '';
        $missingClasses = [];
        foreach ($classes as $class) {
            $parsed = false;
            foreach ($this->classTypes as $classType) {
                if ($tailwindClass = $classType::parse($class)) {
                    $css .= $tailwindClass->toCss() . "\n";
                    $parsed = true;
                    break;
                }
            }
            if (!$parsed) {
                $missingClasses[] = $class;
                if ($this->missingClassHandler) {
                    $css .= call_user_func($this->missingClassHandler, $class) . "\n";
                }
            }
        }
        return ['css' => $css, 'missingClasses' => $missingClasses];
    }

    public function setMissingClassHandler(callable $handler): void
    {
        $this->missingClassHandler = $handler;
    }
}