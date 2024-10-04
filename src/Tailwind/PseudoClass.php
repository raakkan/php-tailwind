<?php

namespace Raakkan\PhpTailwind\Tailwind;

use Raakkan\PhpTailwind\AbstractTailwindClass;
use Raakkan\PhpTailwind\TailwindClassDiscovery;

class PseudoClass extends AbstractTailwindClass
{
    protected string $pseudoClass;
    protected string $actualClass;
    protected array $tailwindClasses;

    public function __construct(string $class, string $pseudoClass, string $actualClass)
    {
        parent::__construct($class);
        $this->tailwindClasses = array_filter(TailwindClassDiscovery::discoverClasses(), function($className) {
            return $className !== self::class && $className !== DarkModeClass::class;
        });
        
        $this->pseudoClass = $pseudoClass;
        $this->actualClass = $actualClass;
    }

    public function toCss(): string
    {
        $css = '';
        foreach ($this->tailwindClasses as $tailwindClass) {
            if ($tailwindClass::parse($this->actualClass)) {
                $parsedClass = $tailwindClass::parse($this->actualClass);
                
                $selector = '.' . str_replace(':', '\\:', $this->value) . ':' . $this->pseudoClass;
                $styles = trim(preg_replace('/\s+/', ' ', $parsedClass->getStyleOnly()));
                $css .= $selector . '{' . $styles . '}';
                break;
            }
        }
        return $css;
    }

    public static function parse($class): ?self
    {
        $pseudoClasses = [
            'hover', 'focus', 'active',
        ];

        foreach ($pseudoClasses as $pseudo) {
            if (strpos($class, $pseudo . ':') === 0) {
                $actualClass = substr($class, strlen($pseudo) + 1);
                return new self($class, $pseudo, $actualClass);
            }
        }

        return null;
    }

    public function getPseudoClass(): string
    {
        return $this->pseudoClass;
    }

    public function getActualClass(): string
    {
        return $this->actualClass;
    }
}