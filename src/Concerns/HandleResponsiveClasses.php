<?php

namespace Raakkan\PhpTailwind\Concerns;

trait HandleResponsiveClasses
{
    protected array $breakpoints = ['sm', 'md', 'lg', 'xl', '2xl'];

    protected function parseResponsiveClass(array $classes): array
    {
        $responsiveClasses = ['default' => []];

        foreach ($this->breakpoints as $breakpoint) {
            $responsiveClasses[$breakpoint] = [];
        }

        foreach ($classes as $class) {
            $breakpoint = 'default';
            $classWithoutBreakpoint = $class;

            foreach ($this->breakpoints as $bp) {
                $prefix = $bp.':';
                if (strpos($class, $prefix) === 0) {
                    $breakpoint = $bp;
                    $classWithoutBreakpoint = substr($class, strlen($prefix));
                    break;
                }
            }

            $responsiveClasses[$breakpoint][] = [
                'original' => $class,
                'parsed' => $classWithoutBreakpoint,
            ];
        }

        return $responsiveClasses;
    }

    protected function wrapResponsiveStyles(array $responsiveClasses, callable $parseCallback): string
    {
        $css = '';

        foreach ($responsiveClasses as $breakpoint => $breakpointClasses) {
            if (empty($breakpointClasses)) {
                continue;
            }

            $breakpointCss = $parseCallback($breakpointClasses, $breakpoint);

            if (empty(trim($breakpointCss))) {
                continue;
            }

            if ($breakpoint === 'default') {
                $css .= $breakpointCss;
            } else {
                $css .= $this->wrapInMediaQuery($breakpoint, $breakpointCss);
            }
        }

        return $css;
    }

    protected function wrapInMediaQuery(string $breakpoint, string $css): string
    {
        $minWidth = $this->getBreakpointWidth($breakpoint);

        return "@media (min-width: {$minWidth}) { {$css} }";
    }

    protected function getBreakpointWidth(string $breakpoint): string
    {
        $breakpointWidths = [
            'sm' => '640px',
            'md' => '768px',
            'lg' => '1024px',
            'xl' => '1280px',
            '2xl' => '1536px',
        ];

        return $breakpointWidths[$breakpoint] ?? '0px';
    }
}
