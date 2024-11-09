<?php

namespace Raakkan\PhpTailwind;

use Raakkan\PhpTailwind\Tailwind\PseudoClass;

class DarkModeClass extends AbstractTailwindClass
{
    protected string $darkPrefix = 'dark:';

    protected array $tailwindClasses;

    protected array $pseudoClasses = ['hover', 'focus', 'active', 'group-hover', 'focus-within', 'focus-visible', 'disabled'];

    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->tailwindClasses = array_filter(TailwindClassDiscovery::discoverClasses(), function ($className) {
            return $className !== self::class && $className !== PseudoClass::class;
        });
    }

    public static function parse(string $value): ?self
    {
        if (strpos($value, 'dark:') === 0) {
            return new self($value);
        }

        return null;
    }

    public function toCss(): string
    {
        $darkClass = $this->value;
        $actualClass = substr($darkClass, strlen($this->darkPrefix));
        $pseudoClass = $this->extractPseudoClass($actualClass);
        $baseClass = str_replace($pseudoClass.':', '', $actualClass);

        foreach ($this->tailwindClasses as $tailwindClass) {
            if ($parsedClass = $tailwindClass::parse($baseClass)) {
                $selector = $this->buildSelector($darkClass, $pseudoClass);
                $styles = $this->formatStyles($parsedClass->getStyleOnly(), $baseClass);

                return $selector.'{'.$styles.'}';
            }
        }

        return '';
    }

    protected function buildSelector(string $darkClass, string $pseudoClass): string
    {
        $selector = '.'.$this->escapeSelector($darkClass);

        if ($pseudoClass) {
            $selector .= ':'.$pseudoClass;
        }

        $selector .= ':where(.dark, .dark *)';

        return $selector;
    }

    protected function escapeSelector(string $selector): string
    {
        $selector = str_replace(':', '\\:', $selector);
        $selector = str_replace('#', '\\#', $selector);
        $selector = str_replace('[', '\\[', $selector);
        $selector = str_replace(']', '\\]', $selector);
        $selector = str_replace('(', '\\(', $selector);
        $selector = str_replace(')', '\\)', $selector);
        $selector = str_replace(',', '\\2c ', $selector);
        $selector = str_replace('/', '\\/', $selector);

        return $selector;
    }

    protected function formatStyles(string $styles, string $className): string
    {
        if (strpos($className, '[') !== false) {
            $styles = preg_replace('/--tw-(text|bg|border)-opacity: 1;?\s*/', '', $styles);
        }
        $styles = rtrim($styles, ';').';';
        $styles = preg_replace('/:\s+/', ':', $styles);

        return $styles;
    }

    protected function extractPseudoClass(string $class): string
    {
        foreach ($this->pseudoClasses as $pseudoClass) {
            if (strpos($class, $pseudoClass.':') !== false) {
                return $pseudoClass;
            }
        }

        return '';
    }
}
