<?php

namespace Raakkan\PhpTailwind\Tailwind\Layout;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class AspectRatioClass extends AbstractTailwindClass
{
    private $isArbitrary;

    public function __construct(string $value, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if ($this->isArbitrary) {
            $escapedValue = str_replace('/', '\/', $this->value);
            return <<<CSS
.aspect-\[{$escapedValue}\] {
    aspect-ratio: {$this->value};
}
CSS;
        }

        switch ($this->value) {
            case 'auto':
                return <<<CSS
.aspect-auto {
    aspect-ratio: auto;
}
CSS;
            case 'square':
                return <<<CSS
.aspect-square {
    aspect-ratio: 1 / 1;
}
CSS;
            case 'video':
                return <<<CSS
.aspect-video {
    aspect-ratio: 16 / 9;
}
CSS;
            default:
                return '';
        }
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^aspect-(\[.+\]|auto|square|video)$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = $value[0] === '[';
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }
            return new self($value, $isArbitrary);
        }
        return null;
    }
}