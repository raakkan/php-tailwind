<?php

namespace Raakkan\PhpTailwind\Concerns;

trait SpacingParser
{
    /**
     * Parse spacing-related Tailwind classes and generate corresponding CSS.
     *
     * @param array $classes An array of Tailwind classes to parse
     * @return string The generated CSS for spacing classes
     */
    public function parseSpacing($classes)
    {
        $parsedRules = [];

        // Update regex to include arbitrary values, negative values, and fractions
        $mp = array_filter($classes, function ($class) {
            return preg_match('/^-?(m|p)(x|y|s|e|t|b|l|r)?-(\[.*?\]|px|\d+(\.\d+)?|(\d+\/\d+))$/', $class);
        });

        // Define valid class identifiers
        $validClasses = ['p', 'm', 'x', 'y', 't', 'r', 'b', 'l', 's', 'e'];

        // Parse each margin/padding rule
        foreach ($mp as $rule) {
            preg_match('/^(-?)([a-z]+)-(\[.*?\]|\d+(?:\.\d+)?|px|(\d+\/\d+))$/', $rule, $matches);
            if ($matches) {
                $isNegative = $matches[1] === '-';
                $class = $matches[2];
                $size = $matches[3];
                
                // Determine if it's a margin or padding class
                if (strlen($class) == 2 && in_array($class[0], ['p', 'm'])) {
                    $type = $class[0];
                    $class = $class[1];
                } else {
                    $type = in_array($class, ['p', 'm']) ? $class : null;
                }
                
                if (in_array($class, $validClasses)) {
                    $parsedRules[] = ['type' => $type, 'class' => $class, 'size' => $size, 'isNegative' => $isNegative];
                }
            }
        }
        
        $css = '';
        // Define CSS property mappings for margin and padding
        $cssMap = [
            'p' => [
                'property' => 'padding',
                'map' => [
                    'p' => '%2$s: %1$s;',
                    'x' => '%2$s-left: %1$s; %2$s-right: %1$s;',
                    'y' => '%2$s-top: %1$s; %2$s-bottom: %1$s;',
                    't' => '%2$s-top: %1$s;',
                    'r' => '%2$s-right: %1$s;',
                    'b' => '%2$s-bottom: %1$s;',
                    'l' => '%2$s-left: %1$s;',
                    's' => '%2$s-inline-start: %1$s;',
                    'e' => '%2$s-inline-end: %1$s;'
                ]
            ],
            'm' => [
                'property' => 'margin',
                'map' => [
                    'm' => '%2$s: %1$s;',
                    'x' => '%2$s-left: %1$s; %2$s-right: %1$s;',
                    'y' => '%2$s-top: %1$s; %2$s-bottom: %1$s;',
                    't' => '%2$s-top: %1$s;',
                    'r' => '%2$s-right: %1$s;',
                    'b' => '%2$s-bottom: %1$s;',
                    'l' => '%2$s-left: %1$s;',
                    's' => '%2$s-inline-start: %1$s;',
                    'e' => '%2$s-inline-end: %1$s;'
                ]
            ]
        ];

        // Generate CSS for each parsed rule
        foreach ($parsedRules as $parsedRule) {
            $type = $parsedRule['type'];
            $class = $parsedRule['class'];
            $size = $parsedRule['size'];
            $isNegative = $parsedRule['isNegative'];
            if (isset($cssMap[$type]) && isset($cssMap[$type]['map'][$class])) {
                $property = $cssMap[$type]['property'];
                $className = $class === $type ? $type : $type . $class;
                $value = $this->calculateValue($size, $isNegative);
                $negativePrefix = $isNegative ? '-' : '';
                $css .= sprintf('.%s%s-%s{%s}', $negativePrefix, $className, $size, sprintf($cssMap[$type]['map'][$class], $value, $property));
            }
        }

        // Parse space classes and margin auto classes
        $css .= $this->parseSpaceClasses($classes);
        $css .= $this->parseMarginAutoClasses($classes);

        return $css;
    }

    /**
     * Calculate the CSS value based on the Tailwind size.
     *
     * @param string $size The Tailwind size (e.g., 'px', '0', '0.5', '1')
     * @param bool $isNegative Whether the value is negative
     * @return string The calculated CSS value
     */
    private function calculateValue($size, $isNegative = false)
    {
        $value = '';
        if ($size === 'px') {
            $value = '1px';
        } elseif ($size === '0') {
            $value = '0px';
        } elseif (strpos($size, '/') !== false) {
            // Handle fractional values
            list($numerator, $denominator) = explode('/', $size);
            $fraction = (intval($numerator) / intval($denominator)) * 100;
            $value = round($fraction, 6) . '%'; // Round to 6 decimal places
        } elseif (is_numeric($size) && strpos($size, '.') !== false) {
            $value = (floatval($size) * 0.25) . 'rem';
        } elseif (preg_match('/^\[(.+)\]$/', $size, $matches)) {
            $value = $matches[1];
            if (preg_match('/^(\d+(\.\d+)?)px$/', $value)) {
                // Return as-is for pixel values
            } elseif (preg_match('/^(\d+(\.\d+)?)rem$/', $value)) {
                // Return as-is for rem values
            } else {
                $value .= 'px'; // Default to pixels for other values
            }
        } else {
            $value = (intval($size) * 0.25) . 'rem';
        }

        return $isNegative ? "-$value" : $value;
    }

    /**
     * Parse space classes and generate corresponding CSS.
     *
     * @param array $classes An array of Tailwind classes
     * @return string The generated CSS for space classes
     */
    private function parseSpaceClasses($classes)
    {
        $css = '';
        $reverseX = in_array('space-x-reverse', $classes);
        $reverseY = in_array('space-y-reverse', $classes);

        foreach ($classes as $class) {
            preg_match('/^-?space-(x|y)-(\[.*?\]|\d+(?:\.\d+)?|px|(\d+\/\d+))$/', $class, $matches);
            if ($matches) {
                $direction = $matches[1];
                $size = $matches[2];
                $value = $this->calculateValue($size);
                $isNegative = strpos($class, '-space-') === 0;
                $css .= $this->generateSpaceCss($direction, $value, $class, $direction === 'x' ? $reverseX : $reverseY, $isNegative);
            }
        }

        // Add CSS for reverse classes
        if ($reverseX) {
            $css .= '.space-x-reverse > :not([hidden]) ~ :not([hidden]) {--tw-space-x-reverse: 1;}';
        }
        if ($reverseY) {
            $css .= '.space-y-reverse > :not([hidden]) ~ :not([hidden]) {--tw-space-y-reverse: 1;}';
        }

        return $css;
    }

    /**
     * Generate CSS for space classes.
     *
     * @param string $direction The direction ('x' or 'y')
     * @param string $value The calculated CSS value
     * @param string $class The original Tailwind class
     * @param bool $reverse Whether to apply reverse functionality
     * @param bool $isNegative Whether the value is negative
     * @return string The generated CSS
     */
    private function generateSpaceCss($direction, $value, $class, $reverse, $isNegative)
    {
        $selector = '> :not([hidden]) ~ :not([hidden])';
        $reverseVar = $direction === 'y' ? '--tw-space-y-reverse' : '--tw-space-x-reverse';
        $mainProp = $direction === 'y' ? 'margin-top' : 'margin-right';
        $reverseProp = $direction === 'y' ? 'margin-bottom' : 'margin-left';
        
        $value = $isNegative ? "-($value)" : $value;

        return sprintf('.%s %s{%s: 0;%s: calc(%s * calc(1 - var(%s)));%s: calc(%s * var(%s));}',
            $class, $selector, $reverseVar, $mainProp, $value, $reverseVar, $reverseProp, $value, $reverseVar
        );
    }

    /**
     * Parse margin auto classes and generate corresponding CSS.
     *
     * @param array $classes An array of Tailwind classes
     * @return string The generated CSS for margin auto classes
     */
    private function parseMarginAutoClasses($classes)
    {
        $css = '';
        $autoClasses = [
            'm-auto' => 'margin: auto;',
            'mx-auto' => 'margin-left: auto; margin-right: auto;',
            'my-auto' => 'margin-top: auto; margin-bottom: auto;',
            'mt-auto' => 'margin-top: auto;',
            'mr-auto' => 'margin-right: auto;',
            'mb-auto' => 'margin-bottom: auto;',
            'ml-auto' => 'margin-left: auto;',
            'ms-auto' => 'margin-inline-start: auto;',
            'me-auto' => 'margin-inline-end: auto;',
        ];

        foreach ($classes as $class) {
            if (isset($autoClasses[$class])) {
                $css .= sprintf('.%s{%s}', $class, $autoClasses[$class]);
            }
        }

        return $css;
    }
}