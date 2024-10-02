<?php

namespace Raakkan\PhpTailwind;
class PhpTailwind
{
    use Concerns\HasPreflight;
    use Concerns\HasHtmlFiles;
    use Concerns\HasBladeFiles;
    private $parser;
    protected $initialClasses;
    protected $parsedClasses;
    protected $missingClasses;

    public function __construct($initialClasses = '')
    {
        $this->parser = new TailwindParser();
        if (!empty($initialClasses)) {
            $this->initialClasses = $initialClasses;
            $this->parse($initialClasses);
        } else {
            $this->initialClasses = '';
            $this->parsedClasses = '';
            $this->missingClasses = [];
        }
    }

    public static function make($initialClasses = '')
    {
        return new self($initialClasses);
    }

    public function parse($classes)
    {
        $classes = array_unique(explode(' ', $classes));
        
        $classes = array_merge($classes, $this->getClassesFromHtmlFiles(), $this->getClassesFromBladeFiles());
        $result = $this->parser->parse($classes);
        $this->parsedClasses = $result['css'];
        $this->missingClasses = $result['missingClasses'];
        return $this;
    }

    public function toString()
    {
        if ($this->isPreflight()) {
            return $this->preflightStyle() . $this->parsedClasses;
        }
        return $this->parsedClasses;
    }

    public function compress()
    {
        $css = $this->parsedClasses;
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        // Remove spaces around semicolons and braces
        $css = preg_replace('/\s*([{}:;])\s*/', '$1', $css);
        // Remove spaces around commas except within property values
        $css = preg_replace('/\s*,\s*(?![^()]*\))/', ',', $css);
        // Remove spaces at the beginning and end of the string
        $css = trim($css);
        
        $this->parsedClasses = $css;
        return $this;
    }

    public function getMissingClasses()
    {
        return $this->missingClasses;
    }
}