<?php

namespace Raakkan\PhpTailwind\Tailwind\Static;

class BordersClasses
{
    public static function getClasses(): array
    {
        return [
            'border-solid' => '.border-solid{border-style:solid;}',
            'border-dashed' => '.border-dashed{border-style:dashed;}',
            'border-dotted' => '.border-dotted{border-style:dotted;}',
            'border-double' => '.border-double{border-style:double;}',
            'border-hidden' => '.border-hidden{border-style:hidden;}',
            'border-none' => '.border-none{border-style:none;}',
            'divide-solid' => '.divide-solid > :not([hidden]) ~ :not([hidden]){border-style:solid;}',
            'divide-dashed' => '.divide-dashed > :not([hidden]) ~ :not([hidden]){border-style:dashed;}',
            'divide-dotted' => '.divide-dotted > :not([hidden]) ~ :not([hidden]){border-style:dotted;}',
            'divide-double' => '.divide-double > :not([hidden]) ~ :not([hidden]){border-style:double;}',
            'divide-none' => '.divide-none > :not([hidden]) ~ :not([hidden]){border-style:none;}',
            'outline' => '.outline{outline-style:solid;}',
            'outline-none' => '.outline-none{outline: 2px solid transparent;outline-offset: 2px;}',
            'outline-dashed' => '.outline-dashed{outline-style:dashed;}',
            'outline-dotted' => '.outline-dotted{outline-style:dotted;}',
            'outline-double' => '.outline-double{outline-style:double;}'
        ];
    }
}
