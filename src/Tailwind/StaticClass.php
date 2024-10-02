<?php

namespace Raakkan\PhpTailwind\Tailwind;
use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Static\LayoutClasses;
use Raakkan\PhpTailwind\Tailwind\Static\FlexGridClasses;
use Raakkan\PhpTailwind\Tailwind\Static\TypographyClasses;
use Raakkan\PhpTailwind\Tailwind\Static\BackgroundsClasses;
use Raakkan\PhpTailwind\Tailwind\Static\BordersClasses;
use Raakkan\PhpTailwind\Tailwind\Static\EffectsClasses;
use Raakkan\PhpTailwind\Tailwind\Static\TablesClasses;
class StaticClass extends AbstractTailwindClass
{
    protected static array $static_classes = [
        LayoutClasses::class,
        FlexGridClasses::class,
        TypographyClasses::class,
        BackgroundsClasses::class,
        BordersClasses::class,
        EffectsClasses::class,
        TablesClasses::class,
    ];

    public function toCss(): string
    {
        $classes = $this->getClasses();
        return $classes[$this->value] ?? '';
    }

    public function getClasses(): array
    {
        $classes = [];
        foreach (static::$static_classes as $static_class) {
            $classes = array_merge($classes, $static_class::getClasses());
        }

        return $classes;
    }

    public static function parse($class): ?self
    {
        $classes = [];
        foreach (static::$static_classes as $static_class) {
            $classes = array_merge($classes, $static_class::getClasses());
        }

        $classes = array_unique($classes);

        if(array_key_exists($class, $classes)) {
            return new self($class);
        }
        
        return null;
    }
}
