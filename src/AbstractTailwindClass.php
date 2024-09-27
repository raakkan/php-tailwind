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

    protected function escapeCalc(string $value): string
    {
        return preg_replace_callback('/calc\((.*?)\)/', function($matches) {
            return 'calc\\(' . str_replace(['+', '%'], ['\\+', '\\%'], $matches[1]) . '\\)';
        }, $value);
    }

    protected function escapeArbitraryValue(string $value): string
    {
        return str_replace(['(', ')', '%', '+'], ['\\(', '\\)', '\\%', '\\+'], $value);
    }
}