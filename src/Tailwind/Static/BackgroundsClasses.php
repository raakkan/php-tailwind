<?php

namespace Raakkan\PhpTailwind\Tailwind\Static;

class BackgroundsClasses
{
    public static function getClasses(): array
    {
        return [
            'bg-fixed' => '.bg-fixed{background-attachment:fixed;}',
            'bg-local' => '.bg-local{background-attachment:local;}',
            'bg-scroll' => '.bg-scroll{background-attachment:scroll;}',
            'bg-clip-border' => '.bg-clip-border{background-clip:border-box;}',
            'bg-clip-padding' => '.bg-clip-padding{background-clip:padding-box;}',
            'bg-clip-content' => '.bg-clip-content{background-clip:content-box;}',
            'bg-clip-text' => '.bg-clip-text{background-clip:text;}',
            'bg-origin-border' => '.bg-origin-border{background-origin:border-box;}',
            'bg-origin-padding' => '.bg-origin-padding{background-origin:padding-box;}',
            'bg-origin-content' => '.bg-origin-content{background-origin:content-box;}',
            'bg-repeat' => '.bg-repeat{background-repeat:repeat;}',
            'bg-no-repeat' => '.bg-no-repeat{background-repeat:no-repeat;}',
            'bg-repeat-x' => '.bg-repeat-x{background-repeat:repeat-x;}',
            'bg-repeat-y' => '.bg-repeat-y{background-repeat:repeat-y;}',
            'bg-repeat-round' => '.bg-repeat-round{background-repeat:round;}',
            'bg-repeat-space' => '.bg-repeat-space{background-repeat:space;}',
        ];
    }
}
