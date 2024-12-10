<?php

namespace Raakkan\PhpTailwind\Tailwind\Typography;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class TypographyClass extends AbstractTailwindClass
{
    protected string $size;
    protected ?string $color;
    protected bool $invert;
    protected bool $notProse;
    
    public function __construct(string $value)
    {
        parent::__construct($value);
        
        // Parse the class components
        $this->parseComponents($value);
    }

    protected function parseComponents(string $value): void
    {
        // Default values
        $this->size = 'base';
        $this->color = null;
        $this->invert = false;
        $this->notProse = false;

        // Handle not-prose first
        if ($value === 'not-prose') {
            $this->notProse = true;
            return;
        }

        $parts = explode(' ', $value);
        
        foreach ($parts as $part) {
            if (strpos($part, 'prose-') === 0) {
                $modifier = substr($part, 6);
                if ($this->isValidSize($modifier)) {
                    $this->size = $modifier;
                } elseif ($this->isValidColor($modifier)) {
                    $this->color = $modifier;
                }
            } elseif ($part === 'prose-invert') {
                $this->invert = true;
            }
        }
    }

    public function toCss(): string
    {
        if($this->value === 'prose') {  
            return $this->getProseClasses();
        }
        if($this->value === 'prose-invert') {
            return $this->getProseInvertClasses();
        }
        // Handle not-prose
        if ($this->notProse) {
            return ".{$this->escapeSelector($this->value)} {
                max-width: none;
                color: inherit;
                font-size: inherit;
                line-height: inherit;
                --tw-prose-body: inherit;
                --tw-prose-headings: inherit;
            }";
        }

        $css = [];
        
        // Base prose styles
        $css[] = $this->getBaseStyles();
        
        // Size-specific styles
        $css[] = $this->getSizeStyles();
        
        // Color theme styles
        if ($this->color) {
            $css[] = $this->getColorStyles();
        }
        
        // Invert styles for dark mode
        if ($this->invert) {
            $css[] = $this->getInvertStyles();
        }
        
        return implode("\n", array_filter($css));
    }

    protected function getBaseStyles(): string
    {
        return ".{$this->escapeSelector($this->value)} {
            max-width: 65ch;
            color: var(--tw-prose-body);
            font-size: 1rem;
            line-height: 1.75;
        }";
    }

    protected function getSizeStyles(): string
    {
        $sizes = [
            'sm' => ['0.875rem', '1.25rem'],
            'base' => ['1rem', '1.75rem'],
            'lg' => ['1.125rem', '1.75rem'],
            'xl' => ['1.25rem', '2rem'],
            '2xl' => ['1.5rem', '2rem'],
        ];

        if (isset($sizes[$this->size])) {
            [$fontSize, $lineHeight] = $sizes[$this->size];
            return ".{$this->escapeSelector($this->value)} {
                font-size: {$fontSize};
                line-height: {$lineHeight};
            }";
        }

        return '';
    }

    protected function getColorStyles(): string
    {
        $colors = [
            'gray' => ['body' => 'rgb(55 65 81)', 'headings' => 'rgb(17 24 39)'],
            'slate' => ['body' => 'rgb(51 65 85)', 'headings' => 'rgb(15 23 42)'],
            'zinc' => ['body' => 'rgb(63 63 70)', 'headings' => 'rgb(24 24 27)'],
            'neutral' => ['body' => 'rgb(64 64 64)', 'headings' => 'rgb(23 23 23)'],
            'stone' => ['body' => 'rgb(68 64 60)', 'headings' => 'rgb(28 25 23)'],
        ];

        if (isset($colors[$this->color])) {
            $color = $colors[$this->color];
            return ".{$this->escapeSelector($this->value)} {
                --tw-prose-body: {$color['body']};
                --tw-prose-headings: {$color['headings']};
            }";
        }

        return '';
    }

    protected function getInvertStyles(): string
    {
        return ".{$this->escapeSelector($this->value)} {
            --tw-prose-body: rgb(229 231 235);
            --tw-prose-headings: rgb(255 255 255);
            --tw-prose-lead: rgb(209 213 219);
            --tw-prose-links: rgb(255 255 255);
            --tw-prose-bold: rgb(255 255 255);
            --tw-prose-counters: rgb(209 213 219);
            --tw-prose-bullets: rgb(156 163 175);
            --tw-prose-hr: rgb(75 85 99);
            --tw-prose-quotes: rgb(243 244 246);
            --tw-prose-quote-borders: rgb(75 85 99);
            --tw-prose-captions: rgb(156 163 175);
            --tw-prose-code: rgb(255 255 255);
            --tw-prose-pre-code: rgb(229 231 235);
            --tw-prose-pre-bg: rgb(31 41 55);
            --tw-prose-th-borders: rgb(75 85 99);
            --tw-prose-td-borders: rgb(55 65 81);
        }";
    }

    public static function parse(string $class): ?self
    {
        if ($class === 'not-prose' || preg_match('/^prose(?:(?:-(?:sm|base|lg|xl|2xl|gray|slate|zinc|neutral|stone))*\s*)*$/', $class)) {
            return new self($class);
        }
        return null;
    }

    protected function isValidSize(string $size): bool
    {
        return in_array($size, ['sm', 'base', 'lg', 'xl', '2xl']);
    }

    protected function isValidColor(string $color): bool
    {
        return in_array($color, ['gray', 'slate', 'zinc', 'neutral', 'stone']);
    }

    protected function escapeSelector(string $selector): string
    {
        return str_replace(' ', '.', $selector);
    }

    public function getProseClasses(): string
    {
        return '.prose{color:var(--tw-prose-body);max-width:65ch}.prose :where(p):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:1.25em;margin-bottom:1.25em}.prose :where([class~="lead"]):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-lead);font-size:1.25em;line-height:1.6;margin-top:1.2em;margin-bottom:1.2em}.prose :where(a):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-links);text-decoration:underline;font-weight:500}.prose :where(strong):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-bold);font-weight:600}.prose :where(a strong):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:inherit}.prose :where(blockquote strong):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:inherit}.prose :where(thead th strong):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:inherit}.prose :where(ol):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:decimal;margin-top:1.25em;margin-bottom:1.25em;padding-inline-start:1.625em}.prose :where(ol[type="A"]):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:upper-alpha}.prose :where(ol[type="a"]):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:lower-alpha}.prose :where(ol[type="A" s]):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:upper-alpha}.prose :where(ol[type="a" s]):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:lower-alpha}.prose :where(ol[type="I"]):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:upper-roman}.prose :where(ol[type="i"]):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:lower-roman}.prose :where(ol[type="I" s]):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:upper-roman}.prose :where(ol[type="i" s]):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:lower-roman}.prose :where(ol[type="1"]):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:decimal}.prose :where(ul):not(:where([class~="not-prose"],[class~="not-prose"] *)){list-style-type:disc;margin-top:1.25em;margin-bottom:1.25em;padding-inline-start:1.625em}.prose :where(ol>li):not(:where([class~="not-prose"],[class~="not-prose"] *))::marker{font-weight:400;color:var(--tw-prose-counters)}.prose :where(ul>li):not(:where([class~="not-prose"],[class~="not-prose"] *))::marker{color:var(--tw-prose-bullets)}.prose :where(dt):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-headings);font-weight:600;margin-top:1.25em}.prose :where(hr):not(:where([class~="not-prose"],[class~="not-prose"] *)){border-color:var(--tw-prose-hr);border-top-width:1px;margin-top:3em;margin-bottom:3em}.prose :where(blockquote):not(:where([class~="not-prose"],[class~="not-prose"] *)){font-weight:500;font-style:italic;color:var(--tw-prose-quotes);border-inline-start-width:.25rem;border-inline-start-color:var(--tw-prose-quote-borders);quotes:"\201C""\201D""\2018""\2019";margin-top:1.6em;margin-bottom:1.6em;padding-inline-start:1em}.prose :where(blockquote p:first-of-type):not(:where([class~="not-prose"],[class~="not-prose"] *))::before{content:open-quote}.prose :where(blockquote p:last-of-type):not(:where([class~="not-prose"],[class~="not-prose"] *))::after{content:close-quote}.prose :where(h1):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-headings);font-weight:800;font-size:2.25em;margin-top:0;margin-bottom:.8888889em;line-height:1.1111111}.prose :where(h1 strong):not(:where([class~="not-prose"],[class~="not-prose"] *)){font-weight:900;color:inherit}.prose :where(h2):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-headings);font-weight:700;font-size:1.5em;margin-top:2em;margin-bottom:1em;line-height:1.3333333}.prose :where(h2 strong):not(:where([class~="not-prose"],[class~="not-prose"] *)){font-weight:800;color:inherit}.prose :where(h3):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-headings);font-weight:600;font-size:1.25em;margin-top:1.6em;margin-bottom:.6em;line-height:1.6}.prose :where(h3 strong):not(:where([class~="not-prose"],[class~="not-prose"] *)){font-weight:700;color:inherit}.prose :where(h4):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-headings);font-weight:600;margin-top:1.5em;margin-bottom:.5em;line-height:1.5}.prose :where(h4 strong):not(:where([class~="not-prose"],[class~="not-prose"] *)){font-weight:700;color:inherit}.prose :where(img):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:2em;margin-bottom:2em}.prose :where(picture):not(:where([class~="not-prose"],[class~="not-prose"] *)){display:block;margin-top:2em;margin-bottom:2em}.prose :where(video):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:2em;margin-bottom:2em}.prose :where(kbd):not(:where([class~="not-prose"],[class~="not-prose"] *)){font-weight:500;font-family:inherit;color:var(--tw-prose-kbd);box-shadow:0 0 0 1px rgb(var(--tw-prose-kbd-shadows)/10%),0 3px 0 rgb(var(--tw-prose-kbd-shadows)/10%);font-size:.875em;border-radius:.3125rem;padding-top:.1875em;padding-inline-end:.375em;padding-bottom:.1875em;padding-inline-start:.375em}.prose :where(code):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-code);font-weight:600;font-size:.875em}.prose :where(code):not(:where([class~="not-prose"],[class~="not-prose"] *))::before{content:"`"}.prose :where(code):not(:where([class~="not-prose"],[class~="not-prose"] *))::after{content:"`"}.prose :where(a code):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:inherit}.prose :where(h1 code):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:inherit}.prose :where(h2 code):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:inherit;font-size:.875em}.prose :where(h3 code):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:inherit;font-size:.9em}.prose :where(h4 code):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:inherit}.prose :where(blockquote code):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:inherit}.prose :where(thead th code):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:inherit}.prose :where(pre):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-pre-code);background-color:var(--tw-prose-pre-bg);overflow-x:auto;font-weight:400;font-size:.875em;line-height:1.7142857;margin-top:1.7142857em;margin-bottom:1.7142857em;border-radius:.375rem;padding-top:.8571429em;padding-inline-end:1.1428571em;padding-bottom:.8571429em;padding-inline-start:1.1428571em}.prose :where(pre code):not(:where([class~="not-prose"],[class~="not-prose"] *)){background-color:transparent;border-width:0;border-radius:0;padding:0;font-weight:inherit;color:inherit;font-size:inherit;font-family:inherit;line-height:inherit}.prose :where(pre code):not(:where([class~="not-prose"],[class~="not-prose"] *))::before{content:none}.prose :where(pre code):not(:where([class~="not-prose"],[class~="not-prose"] *))::after{content:none}.prose :where(table):not(:where([class~="not-prose"],[class~="not-prose"] *)){width:100%;table-layout:auto;margin-top:2em;margin-bottom:2em;font-size:.875em;line-height:1.7142857}.prose :where(thead):not(:where([class~="not-prose"],[class~="not-prose"] *)){border-bottom-width:1px;border-bottom-color:var(--tw-prose-th-borders)}.prose :where(thead th):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-headings);font-weight:600;vertical-align:bottom;padding-inline-end:.5714286em;padding-bottom:.5714286em;padding-inline-start:.5714286em}.prose :where(tbody tr):not(:where([class~="not-prose"],[class~="not-prose"] *)){border-bottom-width:1px;border-bottom-color:var(--tw-prose-td-borders)}.prose :where(tbody tr:last-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){border-bottom-width:0}.prose :where(tbody td):not(:where([class~="not-prose"],[class~="not-prose"] *)){vertical-align:baseline}.prose :where(tfoot):not(:where([class~="not-prose"],[class~="not-prose"] *)){border-top-width:1px;border-top-color:var(--tw-prose-th-borders)}.prose :where(tfoot td):not(:where([class~="not-prose"],[class~="not-prose"] *)){vertical-align:top}.prose :where(th,td):not(:where([class~="not-prose"],[class~="not-prose"] *)){text-align:start}.prose :where(figure>*):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:0;margin-bottom:0}.prose :where(figcaption):not(:where([class~="not-prose"],[class~="not-prose"] *)){color:var(--tw-prose-captions);font-size:.875em;line-height:1.4285714;margin-top:.8571429em}.prose{--tw-prose-body:#374151;--tw-prose-headings:#111827;--tw-prose-lead:#4b5563;--tw-prose-links:#111827;--tw-prose-bold:#111827;--tw-prose-counters:#6b7280;--tw-prose-bullets:#d1d5db;--tw-prose-hr:#e5e7eb;--tw-prose-quotes:#111827;--tw-prose-quote-borders:#e5e7eb;--tw-prose-captions:#6b7280;--tw-prose-kbd:#111827;--tw-prose-kbd-shadows:17 24 39;--tw-prose-code:#111827;--tw-prose-pre-code:#e5e7eb;--tw-prose-pre-bg:#1f2937;--tw-prose-th-borders:#d1d5db;--tw-prose-td-borders:#e5e7eb;--tw-prose-invert-body:#d1d5db;--tw-prose-invert-headings:#fff;--tw-prose-invert-lead:#9ca3af;--tw-prose-invert-links:#fff;--tw-prose-invert-bold:#fff;--tw-prose-invert-counters:#9ca3af;--tw-prose-invert-bullets:#4b5563;--tw-prose-invert-hr:#374151;--tw-prose-invert-quotes:#f3f4f6;--tw-prose-invert-quote-borders:#374151;--tw-prose-invert-captions:#9ca3af;--tw-prose-invert-kbd:#fff;--tw-prose-invert-kbd-shadows:255 255 255;--tw-prose-invert-code:#fff;--tw-prose-invert-pre-code:#d1d5db;--tw-prose-invert-pre-bg:rgb(0 0 0/50%);--tw-prose-invert-th-borders:#4b5563;--tw-prose-invert-td-borders:#374151;font-size:1rem;line-height:1.75}.prose :where(picture>img):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:0;margin-bottom:0}.prose :where(li):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:.5em;margin-bottom:.5em}.prose :where(ol>li):not(:where([class~="not-prose"],[class~="not-prose"] *)){padding-inline-start:.375em}.prose :where(ul>li):not(:where([class~="not-prose"],[class~="not-prose"] *)){padding-inline-start:.375em}.prose :where(.prose>ul>li p):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:.75em;margin-bottom:.75em}.prose :where(.prose>ul>li>p:first-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:1.25em}.prose :where(.prose>ul>li>p:last-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-bottom:1.25em}.prose :where(.prose>ol>li>p:first-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:1.25em}.prose :where(.prose>ol>li>p:last-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-bottom:1.25em}.prose :where(ul ul,ul ol,ol ul,ol ol):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:.75em;margin-bottom:.75em}.prose :where(dl):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:1.25em;margin-bottom:1.25em}.prose :where(dd):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:.5em;padding-inline-start:1.625em}.prose :where(hr+*):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:0}.prose :where(h2+*):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:0}.prose :where(h3+*):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:0}.prose :where(h4+*):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:0}.prose :where(thead th:first-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){padding-inline-start:0}.prose :where(thead th:last-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){padding-inline-end:0}.prose :where(tbody td,tfoot td):not(:where([class~="not-prose"],[class~="not-prose"] *)){padding-top:.5714286em;padding-inline-end:.5714286em;padding-bottom:.5714286em;padding-inline-start:.5714286em}.prose :where(tbody td:first-child,tfoot td:first-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){padding-inline-start:0}.prose :where(tbody td:last-child,tfoot td:last-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){padding-inline-end:0}.prose :where(figure):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:2em;margin-bottom:2em}.prose :where(.prose>:first-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-top:0}.prose :where(.prose>:last-child):not(:where([class~="not-prose"],[class~="not-prose"] *)){margin-bottom:0}';
    }

    public function getProseInvertClasses(): string
    {
        return '.prose-invert{--tw-prose-body:var(--tw-prose-invert-body);--tw-prose-headings:var(--tw-prose-invert-headings);--tw-prose-lead:var(--tw-prose-invert-lead);--tw-prose-links:var(--tw-prose-invert-links);--tw-prose-bold:var(--tw-prose-invert-bold);--tw-prose-counters:var(--tw-prose-invert-counters);--tw-prose-bullets:var(--tw-prose-invert-bullets);--tw-prose-hr:var(--tw-prose-invert-hr);--tw-prose-quotes:var(--tw-prose-invert-quotes);--tw-prose-quote-borders:var(--tw-prose-invert-quote-borders);--tw-prose-captions:var(--tw-prose-invert-captions);--tw-prose-kbd:var(--tw-prose-invert-kbd);--tw-prose-kbd-shadows:var(--tw-prose-invert-kbd-shadows);--tw-prose-code:var(--tw-prose-invert-code);--tw-prose-pre-code:var(--tw-prose-invert-pre-code);--tw-prose-pre-bg:var(--tw-prose-invert-pre-bg);--tw-prose-th-borders:var(--tw-prose-invert-th-borders);--tw-prose-td-borders:var(--tw-prose-invert-td-borders)}';
    }
} 