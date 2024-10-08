<?php

namespace Raakkan\PhpTailwind\Tailwind;
use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\Tailwind\Static\LayoutClasses;
use Raakkan\PhpTailwind\Tailwind\Static\TablesClasses;
use Raakkan\PhpTailwind\Tailwind\Static\BordersClasses;
use Raakkan\PhpTailwind\Tailwind\Static\EffectsClasses;
use Raakkan\PhpTailwind\Tailwind\Static\FlexGridClasses;
use Raakkan\PhpTailwind\Tailwind\Static\TypographyClasses;
use Raakkan\PhpTailwind\Tailwind\Static\BackgroundsClasses;
use Raakkan\PhpTailwind\Tailwind\Static\InteractivityClasses;

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
        InteractivityClasses::class,
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
            $classes = array_merge($classes, $static_class::getClasses(), static::getOtherClasses());
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
        $other_classes = static::getOtherClasses();
        $classes = array_merge($classes, $other_classes);
      
        if(array_key_exists($class, $classes)) {
            return new self($class);
        }
        
        return null;
    }

    protected static function getOtherClasses(): array
    {
        return [
            'sr-only' => '.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border-width:0;}',
            'not-sr-only' => '.not-sr-only{position:static;width:auto;height:auto;padding:0;margin:0;overflow:visible;clip:auto;white-space:normal;}',
            'forced-color-adjust-auto' => '.forced-color-adjust-auto{forced-color-adjust: auto;}',
            'forced-color-adjust-none' => '.forced-color-adjust-none{forced-color-adjust: none;}',
        ];
    }
}
