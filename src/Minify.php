<?php

namespace Raakkan\PhpTailwind;

class Minify
{
    /**
     * @var string
     */
    protected $css;

    /**
     * @var array
     */
    protected $exclusions = [];

    /**
     * @var array
     */
    protected $placeholders = [];

    /**
     * @param string $css
     */
    public function __construct(string $css = '')
    {
        $this->css = $css;
    }

    /**
     * Add CSS content.
     *
     * @param string $css
     * @return $this
     */
    public function add(string $css): self
    {
        $this->css .= $css;
        return $this;
    }

    /**
     * Minify the CSS.
     *
     * @return string
     */
    public function minify(): string
    {
        $this->extractExclusions();
        $this->removeComments();
        $this->removeWhitespace();
        $this->shortenHexColors();
        // $this->shortenZeroes();
        $this->shortenFontWeights();
        $this->stripEmptyTags();
        $this->optimizeShorthands();
        $this->restoreExclusions();

        return $this->css;
    }

    /**
     * Extract strings and comments to exclude them from minification.
     */
    protected function extractExclusions(): void
    {
        $this->extractStrings();
        $this->extractComments();
    }

    /**
     * Extract strings to exclude them from minification.
     */
    protected function extractStrings(): void
    {
        $regex = '/(\'(?:[^\'\\\]++|\\\.)*+\'|"(?:[^"\\\]++|\\\.)*+")/';
        $this->css = preg_replace_callback($regex, function ($match) {
            $placeholder = 'STRING_' . count($this->placeholders) . '_';
            $this->placeholders[$placeholder] = $match[0];
            return $placeholder;
        }, $this->css);
    }

    /**
     * Extract comments to exclude them from minification.
     */
    protected function extractComments(): void
    {
        $regex = '/\/\*[\s\S]*?\*\//';
        $this->css = preg_replace_callback($regex, function ($match) {
            $placeholder = 'COMMENT_' . count($this->placeholders) . '_';
            $this->placeholders[$placeholder] = $match[0];
            return $placeholder;
        }, $this->css);
    }

    /**
     * Remove comments.
     */
    protected function removeComments(): void
    {
        $this->css = preg_replace('/\/\*[\s\S]*?\*\//', '', $this->css);
    }

    /**
     * Remove whitespace.
     */
    protected function removeWhitespace(): void
    {
        $this->css = preg_replace('/\s+/', ' ', $this->css);
        $this->css = preg_replace('/\s*([:;{}])\s*/', '$1', $this->css);
        $this->css = preg_replace('/;}/', '}', $this->css);
    }

    /**
     * Shorten hex colors.
     */
    protected function shortenHexColors(): void
    {
        $regex = '/#([a-f0-9])\1([a-f0-9])\2([a-f0-9])\3/i';
        $this->css = preg_replace($regex, '#$1$2$3', $this->css);
    }

    /**
     * Shorten zeroes.
     */
    protected function shortenZeroes(): void
    {
        $this->css = preg_replace('/(?<=[\s:,])(0)(px|em|rem|%|in|cm|mm|pc|pt|ex|vh|vw|vmin|vmax)/', '$1', $this->css);
        $this->css = preg_replace('/(?<=[\s:,])(0\.)([0-9]+)/', '.$2', $this->css);
    }

    /**
     * Shorten font weights.
     */
    protected function shortenFontWeights(): void
    {
        $this->css = preg_replace('/font-weight\s*:\s*normal\s*;/', 'font-weight:400;', $this->css);
        $this->css = preg_replace('/font-weight\s*:\s*bold\s*;/', 'font-weight:700;', $this->css);
    }

    /**
     * Strip empty tags.
     */
    protected function stripEmptyTags(): void
    {
        $this->css = preg_replace('/[^{}]+\{\s*\}/', '', $this->css);
    }

    /**
     * Optimize shorthands.
     */
    protected function optimizeShorthands(): void
    {
        $this->optimizeMarginPadding();
        $this->optimizeBorders();
        $this->optimizeBackgrounds();
    }

    /**
     * Optimize margin and padding shorthands.
     */
    protected function optimizeMarginPadding(): void
    {
        $properties = ['margin', 'padding'];
        foreach ($properties as $property) {
            $regex = "/$property-(?:top|right|bottom|left)\\s*:\\s*([^;\\}]+)\\s*;\\s*" .
                     "$property-(?:top|right|bottom|left)\\s*:\\s*([^;\\}]+)\\s*;\\s*" .
                     "$property-(?:top|right|bottom|left)\\s*:\\s*([^;\\}]+)\\s*;\\s*" .
                     "$property-(?:top|right|bottom|left)\\s*:\\s*([^;\\}]+)\\s*;/i";
            $this->css = preg_replace_callback($regex, function ($matches) use ($property) {
                $values = array_slice($matches, 1);
                if (count(array_unique($values)) === 1) {
                    return "$property:{$values[0]};";
                }
                if ($values[0] === $values[2] && $values[1] === $values[3]) {
                    return "$property:{$values[0]} {$values[1]};";
                }
                return "$property:{$values[0]} {$values[1]} {$values[2]} {$values[3]};";
            }, $this->css);
        }
    }

    /**
     * Optimize border shorthands.
     */
    protected function optimizeBorders(): void
    {
        $regex = '/border-(top|right|bottom|left)\\s*:\\s*([^;\\}]+)\\s*;\\s*' .
                 'border-(top|right|bottom|left)\\s*:\\s*([^;\\}]+)\\s*;\\s*' .
                 'border-(top|right|bottom|left)\\s*:\\s*([^;\\}]+)\\s*;\\s*' .
                 'border-(top|right|bottom|left)\\s*:\\s*([^;\\}]+)\\s*;/i';
        $this->css = preg_replace_callback($regex, function ($matches) {
            $values = array_slice($matches, 2, 8, true);
            if (count(array_unique($values)) === 1) {
                return "border:{$values[$matches[1]]};";
            }
            return $matches[0];
        }, $this->css);
    }

    /**
     * Optimize background shorthands.
     */
    protected function optimizeBackgrounds(): void
    {
        $properties = ['color', 'image', 'repeat', 'position', 'size'];
        $regex = '/background-(' . implode('|', $properties) . ')\\s*:\\s*([^;\\}]+)\\s*;\\s*/i';
        $this->css = preg_replace_callback($regex, function ($matches) use ($properties) {
            static $background = [];
            $background[$matches[1]] = $matches[2];
            if (count($background) === count($properties)) {
                $result = "background:{$background['color']} {$background['image']} {$background['repeat']} " .
                          "{$background['position']}/{$background['size']};";
                $background = [];
                return $result;
            }
            return $matches[0];
        }, $this->css);
    }

    /**
     * Restore excluded content.
     */
    protected function restoreExclusions(): void
    {
        $this->css = strtr($this->css, $this->placeholders);
    }
}