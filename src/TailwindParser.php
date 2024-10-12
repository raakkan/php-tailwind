<?php

namespace Raakkan\PhpTailwind;

use Raakkan\PhpTailwind\Concerns\HandleResponsiveClasses;

class TailwindParser
{
    use HandleResponsiveClasses;

    private $classTypes = [];
    private $missingClassHandler;
    private $invalidCssClasses = [];
    private $parsedClasses = [];
    private $missingClasses = [];
    private $css = '';
    public function __construct()
    {
        $this->classTypes = TailwindClassDiscovery::discoverClasses();
    }

    public function parse(array|string $classes): array
    {
        if (is_string($classes)) {
            $classes = explode(' ', $classes);
        }
        $responsiveClasses = $this->parseResponsiveClass($classes);
        $missingClasses = [];
        $parsedClasses = [];
        $darkModeClasses = [];

        $css = $this->wrapResponsiveStyles($responsiveClasses, function ($breakpointClasses, $breakpoint) use (&$missingClasses, &$parsedClasses, &$darkModeClasses) {
            $breakpointCss = '';
            
            foreach ($breakpointClasses as $classInfo) {
                $class = $classInfo['parsed'];
                if (strpos($class, 'dark:') === 0) {
                    $darkModeClasses[] = ['class' => $class, 'breakpoint' => $breakpoint];
                    continue;
                }
                
                $parsed = $this->parseClass($class, $breakpointCss, $breakpoint);
                $classWithBreakpoint = $this->addBreakpointToClass($class, $breakpoint);
                if ($parsed) {
                    $parsedClasses[] = $classWithBreakpoint;
                } else {
                    $missingClasses[] = $classWithBreakpoint;
                }
            }
            
            return $breakpointCss;
        });

        $darkModeCss = $this->processDarkModeClasses($darkModeClasses);
        $css .= $darkModeCss;

        $this->parsedClasses = array_values(array_unique($parsedClasses));
        $this->missingClasses = array_values(array_unique($missingClasses));
        $this->css = $css;
        $this->invalidCssClasses = $this->getInvalidCssClasses();

        return [
            'css' => $this->css,
            'missingClasses' => $this->missingClasses,
            'parsedClasses' => $this->parsedClasses,
            'invalidCssClasses' => $this->invalidCssClasses
        ];
    }

    private function addBreakpointToClass(string $class, string $breakpoint): string
    {
        if ($breakpoint === 'default') {
            return $class;
        }
        return "{$breakpoint}\\:{$class}";
    }

    private function parseClass(string $class, string &$css, string $breakpoint): bool
    {
        $class = str_replace(['{', '}', ' ', '\'', '"', '\\\''], '', $class);
        foreach ($this->classTypes as $classType) {
            if ($tailwindClass = $classType::parse($class)) {
                $classCss = $tailwindClass->toCss();
                if ($this->isValidCssStyle($classCss)) {
                    $css .= $this->addBreakpointToSelector($classCss, $breakpoint);
                    return true;
                } else {
                    $this->invalidCssClasses[] = $classCss;
                    return false;
                }
            }
        }

        if ($this->missingClassHandler && is_callable($this->missingClassHandler)) {
            $handlerCss = call_user_func($this->missingClassHandler, $class);
            if ($this->isValidCssStyle($handlerCss)) {
                $css .= $this->addBreakpointToSelector($handlerCss, $breakpoint);
                return true;
            } else {
                $this->invalidCssClasses[] = $handlerCss;
            }
        }

        return false;
    }

    private function addBreakpointToSelector(string $css, string $breakpoint): string
    {
        if ($breakpoint === 'default') {
            return $css;
        }

        // Split the CSS rule into selector and declarations
        $parts = explode('{', $css, 2);
        if (count($parts) !== 2) {
            return $css; // Invalid CSS, return as is
        }

        $selector = trim($parts[0]);
        $declarations = '{' . $parts[1];

        // Add the breakpoint to the selector
        $newSelector = ".{$breakpoint}\\:" . str_replace('.', '', $selector);

        return $newSelector . $declarations;
    }

    private function isValidCssStyle(string $cssRule): bool
    {
        return preg_match('/^.+\s*{.+}$/s', trim($cssRule)) === 1;
    }

    public function setMissingClassHandler(callable $handler): void
    {
        $this->missingClassHandler = $handler;
    }

    public function getInvalidCssClasses(): array
    {
        return array_values(array_filter($this->invalidCssClasses, function($value) {
            return !empty(trim($value));
        }));
    }

    public function getParsedClasses(): array
    {
        return $this->parsedClasses;
    }

    public function getMissingClasses(): array
    {
        return $this->missingClasses;
    }

    private function processDarkModeClasses(array $darkModeClasses): string
    {
        $darkModeCss = '';
        foreach ($darkModeClasses as $classInfo) {
            $class = $classInfo['class'];
            $breakpoint = $classInfo['breakpoint'];
            $parsed = $this->parseDarkModeClass($class, $darkModeCss, $breakpoint);
            $classWithBreakpoint = $this->addBreakpointToClass($class, $breakpoint);
            if ($parsed) {
                $this->parsedClasses[] = $classWithBreakpoint;
            } else {
                $this->missingClasses[] = $classWithBreakpoint;
            }
        }
        return $darkModeCss;
    }

    private function parseDarkModeClass(string $class, string &$css, string $breakpoint): bool
    {
        if ($dark = DarkModeClass::parse($class)) {
            $css .= $dark->toCss();
        }

        return false;
    }
}