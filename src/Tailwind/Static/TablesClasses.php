<?php

namespace Raakkan\PhpTailwind\Tailwind\Static;

class TablesClasses
{
    public static function getClasses(): array
    {
        return [
            'border-collapse' => '.border-collapse{border-collapse:collapse;}',
            'border-separate' => '.border-separate{border-collapse:separate;}',
            'table-auto' => '.table-auto{table-layout:auto;}',
            'table-fixed' => '.table-fixed{table-layout:fixed;}',
            'caption-bottom' => '.caption-bottom{caption-side:bottom;}',
            'caption-top' => '.caption-top{caption-side:top;}',
        ];
    }
}
