<?php

namespace Raakkan\PhpTailwind\Concerns;

trait SpacingParser
{
    public function parseSpacing($classes)
    {
        $parsedRules = [];

        $mp = array_filter($classes, function ($class) {
            return preg_match('/^(m|p)(x|y|s|e|t|b|l|r)?-(px|\d+(\.\d+)?)$/', $class);
        });

        $validClasses = ['p', 'm', 'x', 'y', 't', 'r', 'b', 'l', 's', 'e'];

        foreach ($mp as $rule) {
            preg_match('/([a-z-]+)-(\d+(?:\.\d+)?|px)/', $rule, $matches);
            if ($matches) {
                $class = $matches[1];
                if (strlen($class) == 2 && in_array($class[0], ['p', 'm'])) {
                    $type = $class[0];
                    $class = $class[1];
                } else {
                    $type = in_array($class, ['p', 'm']) ? $class : null;
                }
                $size = $matches[2];
                if (in_array($class, $validClasses)) {
                    $parsedRules[] = ['type' => $type, 'class' => $class, 'size' => $size];
                }
            }
        }
        
        $css = '';
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

        foreach ($parsedRules as $parsedRule) {
            $type = $parsedRule['type'];
            $class = $parsedRule['class'];
            $size = $parsedRule['size'];
            if (isset($cssMap[$type]) && isset($cssMap[$type]['map'][$class])) {
                $property = $cssMap[$type]['property'];
                $className = $class === $type ? $type : $type . $class;
                $value = $this->calculateValue($size);
                $css .= sprintf('.%s-%s{%s}', $className, $size, sprintf($cssMap[$type]['map'][$class], $value, $property));
            }
        }

        $css .= $this->parseSpaceClasses($classes);

        return $css;
    }

    private function calculateValue($size)
    {
        if ($size === 'px') {
            return '1px';
        } elseif ($size === '0') {
            return '0px';
        } elseif (strpos($size, '.') !== false) {
            return (floatval($size) * 0.25) . 'rem';
        } else {
            return (intval($size) * 0.25) . 'rem';
        }
    }

    private function parseSpaceClasses($classes)
    {
        $css = '';
        foreach ($classes as $class) {
            preg_match('/space-(x|y)-(\d+(?:\.\d+)?|px)/', $class, $matches);
            if ($matches) {
                $direction = $matches[1];
                $size = $matches[2];
                $value = $this->calculateValue($size);
                $css .= $this->generateSpaceCss($direction, $value, $class);
            }
        }
        return $css;
    }

    private function generateSpaceCss($direction, $value, $class)
    {
        $selector = '> :not([hidden]) ~ :not([hidden])';
        if ($direction === 'y') {
            return sprintf('.%s %s{margin-top:%s;margin-bottom:%s;}', $class, $selector, $value, $value);
        } else {
            return sprintf('.%s %s{margin-left:%s;margin-right:%s;}', $class, $selector, $value, $value);
        }
    }
}