<?php

namespace Raakkan\PhpTailwind\Tailwind\Static;

class InteractivityClasses
{
    public static function getClasses(): array
    {
        return [
            'appearance-none' => '.appearance-none{appearance:none;}',
            'appearance-auto' => '.appearance-auto{appearance:auto;}',
            'pointer-events-none' => '.pointer-events-none{pointer-events:none;}',
            'pointer-events-auto' => '.pointer-events-auto{pointer-events:auto;}',
            'resize-none' => '.resize-none{resize:none;}',
            'resize-y' => '.resize-y{resize:vertical;}',
            'resize-x' => '.resize-x{resize:horizontal;}',
            'resize' => '.resize{resize:both;}',
            'scroll-auto' => '.scroll-auto{scroll-behavior:auto;}',
            'scroll-smooth' => '.scroll-smooth{scroll-behavior:smooth;}',
            'snap-start' => '.snap-start{scroll-snap-align:start;}',
            'snap-end' => '.snap-end{scroll-snap-align:end;}',
            'snap-center' => '.snap-center{scroll-snap-align:center;}',
            'snap-align-none' => '.snap-align-none{scroll-snap-align:none;}',
            'snap-normal' => '.snap-normal{scroll-snap-stop:normal;}',
            'snap-always' => '.snap-always{scroll-snap-stop:always;}',
            'snap-none' => '.snap-none{scroll-snap-type:none;}',
            'snap-x' => '.snap-x{scroll-snap-type:x var(--tw-scroll-snap-strictness);}',
            'snap-y' => '.snap-y{scroll-snap-type:y var(--tw-scroll-snap-strictness);}',
            'snap-both' => '.snap-both{scroll-snap-type:both var(--tw-scroll-snap-strictness);}',
            'snap-mandatory' => '.snap-mandatory{--tw-scroll-snap-strictness:mandatory;}',
            'snap-proximity' => '.snap-proximity{--tw-scroll-snap-strictness:proximity;}',
            'touch-auto' => '.touch-auto{touch-action:auto;}',
            'touch-none' => '.touch-none{touch-action:none;}',
            'touch-pan-x' => '.touch-pan-x{touch-action:pan-x;}',
            'touch-pan-left' => '.touch-pan-left{touch-action:pan-left;}',
            'touch-pan-right' => '.touch-pan-right{touch-action:pan-right;}',
            'touch-pan-y' => '.touch-pan-y{touch-action:pan-y;}',
            'touch-pan-up' => '.touch-pan-up{touch-action:pan-up;}',
            'touch-pan-down' => '.touch-pan-down{touch-action:pan-down;}',
            'touch-pinch-zoom' => '.touch-pinch-zoom{touch-action:pinch-zoom;}',
            'touch-manipulation' => '.touch-manipulation{touch-action:manipulation;}',
            'select-none' => '.select-none{user-select:none;}',
            'select-text' => '.select-text{user-select:text;}',
            'select-all' => '.select-all{user-select:all;}',
            'select-auto' => '.select-auto{user-select:auto;}',
        ];
    }
}
