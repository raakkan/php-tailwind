<?php

namespace Raakkan\PhpTailwind\Pipes;

use Raakkan\PhpTailwind\Concerns\SpacingParser;

class SpacingPipe
{
    use SpacingParser;

    public function handle($classes)
    {
        return $this->parseSpacing($classes);
    }
}