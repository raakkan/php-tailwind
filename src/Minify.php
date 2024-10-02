<?php

namespace Raakkan\PhpTailwind;

class Minify
{
    public static function minify(string $css): string
    {
        // Process each CSS rule
        $css = self::processCssRules($css);

        // Remove newlines and extra spaces outside of brackets
        $result = preg_replace('/\s+(?=[^{}]*\{)|(?<=[^{}]*\})\s+/', ' ', $css);

        return $result ?? $css;
    }

    private static function processCssRules(string $css): string
    {
        preg_match_all('/([^{}]+)\{([^{}]+)\}/', $css, $matches, PREG_SET_ORDER);
        
        $processedCss = '';
        foreach ($matches as $match) {
            $selector = self::minifySelector($match[1]);
            $properties = self::minifyProperties($match[2]);
            $processedCss .= $selector . '{' . $properties . '}';
        }
        
        return $processedCss;
    }

    private static function minifySelector(string $selector): string
    {
        return trim(preg_replace('/\s+/', ' ', $selector));
    }

    private static function minifyProperties(string $properties): string
    {
        $propArray = explode(';', $properties);
        $minifiedProps = array_map([self::class, 'minifyProperty'], $propArray);
        return implode('', array_filter($minifiedProps));
    }

    private static function minifyProperty(string $prop): string
    {
        if (empty(trim($prop))) {
            return '';
        }
        list($property, $value) = array_map('trim', explode(':', $prop, 2));
        $value = preg_replace('/,\s+/', ',', $value);
        return $property . ':' . $value . ';';
    }
}