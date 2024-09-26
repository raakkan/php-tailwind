<?php

namespace Raakkan\PhpTailwind\Pipes;

use Raakkan\PhpTailwind\Concerns\LayoutParser;

class LayoutPipe
{
    use LayoutParser;

    public function handle($classes)
    {
        return $this->parseLayout($classes);
    }
}