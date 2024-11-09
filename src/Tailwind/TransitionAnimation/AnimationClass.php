<?php

namespace Raakkan\PhpTailwind\Tailwind\TransitionAnimation;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class AnimationClass extends AbstractTailwindClass
{
    private $isArbitrary;

    public function __construct(string $value, bool $isArbitrary = false)
    {
        parent::__construct($value);
        $this->isArbitrary = $isArbitrary;
    }

    public function toCss(): string
    {
        if (! $this->isValidValue()) {
            return '';
        }

        $animationValue = $this->getAnimationValue();
        $classValue = $this->isArbitrary ? "\\[{$this->escapeArbitraryValue($this->value)}\\]" : $this->value;

        $css = ".animate-{$classValue}{animation:{$animationValue};}";

        // Add keyframes for predefined animations
        if (! $this->isArbitrary) {
            $css .= $this->getKeyframes();
        }

        return $css;
    }

    private function getAnimationValue(): string
    {
        $animations = [
            'none' => 'none',
            'spin' => 'spin 1s linear infinite',
            'ping' => 'ping 1s cubic-bezier(0, 0, 0.2, 1) infinite',
            'pulse' => 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            'bounce' => 'bounce 1s infinite',
        ];

        if ($this->isArbitrary) {
            // For arbitrary values, replace underscores with spaces
            return str_replace('_', ' ', $this->value);
        }

        return $animations[$this->value] ?? '';
    }

    private function getKeyframes(): string
    {
        $keyframes = [
            'spin' => '@keyframes spin{to{transform:rotate(360deg);}}',
            'ping' => '@keyframes ping{75%,100%{transform:scale(2);opacity:0;}}',
            'pulse' => '@keyframes pulse{50%{opacity:.5;}}',
            'bounce' => '@keyframes bounce{0%,100%{transform:translateY(-25%);animation-timing-function:cubic-bezier(0.8,0,1,1);}50%{transform:none;animation-timing-function:cubic-bezier(0,0,0.2,1);}}',
        ];

        return $keyframes[$this->value] ?? '';
    }

    private function isValidValue(): bool
    {
        if ($this->isArbitrary) {
            return true;
        }

        $validValues = ['none', 'spin', 'ping', 'pulse', 'bounce'];

        return in_array($this->value, $validValues);
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^animate-(none|spin|ping|pulse|bounce|\[.+\])$/', $class, $matches)) {
            $value = $matches[1];
            $isArbitrary = str_starts_with($value, '[') && str_ends_with($value, ']');
            if ($isArbitrary) {
                $value = trim($value, '[]');
            }

            return new self($value, $isArbitrary);
        }

        return null;
    }

    // private function escapeArbitraryValue(string $value): string
    // {
    //     return str_replace(['@', '.', ','], ['\@', '\.', '\2c '], $value);
    // }
}
