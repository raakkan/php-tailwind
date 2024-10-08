<?php

namespace Raakkan\PhpTailwind;
class PhpTailwind
{
    use Concerns\HasPreflight;
    use Concerns\HasHtmlFiles;
    use Concerns\HasBladeFiles;
    private $parser;
    private $minifier;
    private $minifiedCss;
    private $css;
    protected $initialClasses;
    protected $parsedClasses;
    protected $missingClasses;
    protected $invalidCssClasses;
    public function __construct($initialClasses = '')
    {
        $this->parser = new TailwindParser();
        $this->minifier = new Minify();
        if (!empty($initialClasses)) {
            $this->initialClasses = $initialClasses;
            $this->parse($initialClasses);
        } else {
            $this->initialClasses = '';
            $this->parsedClasses = '';
            $this->missingClasses = [];
            $this->invalidCssClasses = [];
        }
    }

    public static function make($initialClasses = '')
    {
        return new self($initialClasses);
    }

    public function parse(string | array | null $classes = null)
    {
        if (is_string($classes)) {
            $classes = explode(' ', $classes);
        }
        $classes = array_unique($classes);
        $this->initialClasses = $classes;
        $result = $this->parser->parse($classes);
        $this->parsedClasses = $result['css'];
        $this->missingClasses = $result['missingClasses'];
        $this->invalidCssClasses = $result['invalidCssClasses'];
        return $this;
    }

    public function minify()
    {
        $css = $this->parsedClasses;
        if ($this->isPreflight()) {
            $css = $this->preflightStyle() . $css;
        }
        $this->minifiedCss = $this->minifier->add($css)->minify();
        return $this;
    }

    public function toString()
    {
        $css = '';
        if ($this->minifiedCss) {
            $css = $this->minifiedCss;
        } else {
            $css = $this->parsedClasses;
            if ($this->isPreflight()) {
                $css = $this->preflightStyle() . $css;
            }
        }
        
        return $css;
    }

    public function getMissingClasses()
    {
        return $this->parser->getMissingClasses();
    }

    public function getInvalidClasses()
    {
        return $this->parser->getInvalidCssClasses();
    }

    public function getParsedClasses()
    {
        return $this->parser->getParsedClasses();
    }
}