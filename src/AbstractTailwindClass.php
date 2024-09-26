<?php

namespace Raakkan\PhpTailwind;

abstract class AbstractTailwindClass
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    abstract public function toCss(): string;

    public static function parse(string $class): ?self
    {
        return null;
    }
}