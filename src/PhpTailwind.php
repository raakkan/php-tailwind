<?php

namespace Raakkan\PhpTailwind;
use Illuminate\Support\Facades\Pipeline;
use Raakkan\PhpTailwind\Pipes\SpacingPipe;

class PhpTailwind
{
    protected $initialClasses;
    protected $parsedClasses;
    public function __construct($initialClasses = '')
    {
        if (!empty($initialClasses)) {
            $this->initialClasses = $initialClasses;
            $this->parsedClasses = $this->parse($initialClasses);
        } else {
            $this->initialClasses = '';
            $this->parsedClasses = '';
        }
    }

    public static function make($initialClasses = '')
    {
        return new self($initialClasses);
    }

    public function parse($classes)
    {
        $classes = array_unique(explode(' ', $classes));
        
        $parsedClasses = Pipeline::send($classes)
            ->through([
                SpacingPipe::class,
            ])
            ->thenReturn();

        return $parsedClasses;
    }

    public function toString()
    {
        return $this->parsedClasses;
    }
}