<?php

namespace Raakkan\PhpTailwind;
class PhpTailwind
{
    private $parser;
    protected $initialClasses;
    protected $parsedClasses;
    public function __construct($initialClasses = '')
    {
        $this->parser = new TailwindParser();
        if (!empty($initialClasses)) {
            $this->initialClasses = $initialClasses;
            $this->parse($initialClasses);
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
        
        $this->parsedClasses = $this->parser->parse($classes);
        return $this;
    }

    public function toString()
    {
        return $this->parsedClasses;
    }

    public function beautify()
    {
        $css = $this->parsedClasses;
        $beautified = '';
        $indentLevel = 0;
        $inRule = false;

        foreach (explode(';', $css) as $declaration) {
            $declaration = trim($declaration);
            if (empty($declaration)) continue;

            if (strpos($declaration, '}') !== false) {
                $indentLevel--;
                $beautified .= str_repeat('    ', $indentLevel) . "}\n";
                $inRule = false;
            } elseif (strpos($declaration, '{') !== false) {
                $beautified .= str_repeat('    ', $indentLevel) . "$declaration\n";
                $indentLevel++;
                $inRule = true;
            } else {
                $beautified .= str_repeat('    ', $indentLevel) . "$declaration;\n";
            }
        }

        $this->parsedClasses = $beautified;
        return $this;
    }

    public function compress()
    {
        $css = $this->parsedClasses;
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        // Remove all spaces
        $css = preg_replace('/\s+/', '', $css);
        
        $this->parsedClasses = $css;
        return $this;
    }
}