<?php

namespace Raakkan\PhpTailwind\Spacing;

use Raakkan\PhpTailwind\AbstractTailwindClass;

class SpaceClass extends AbstractTailwindClass
{
    private $direction;
    private $isReverse;

    public function __construct(string $value, string $direction, bool $isReverse = false)
    {
        parent::__construct($value);
        $this->direction = $direction;
        $this->isReverse = $isReverse;
    }

    public function toCss(): string
    {
        $value = SpacingValueCalculator::calculate($this->value);
        
        if ($this->isReverse) {
            return <<<CSS
.space-{$this->direction}-reverse > :not([hidden]) ~ :not([hidden]) {
    --tw-space-{$this->direction}-reverse: 1;
}
CSS;
        }

        $property1 = $this->direction === 'x' ? 'margin-right' : 'margin-bottom';
        $property2 = $this->direction === 'x' ? 'margin-left' : 'margin-top';

        return <<<CSS
.space-{$this->direction}-{$this->value} > :not([hidden]) ~ :not([hidden]) {
    --tw-space-{$this->direction}-reverse: 0;
    {$property1}: calc({$value} * var(--tw-space-{$this->direction}-reverse));
    {$property2}: calc({$value} * calc(1 - var(--tw-space-{$this->direction}-reverse)));
}
CSS;
    }

    public static function parse(string $class): ?self
    {
        if (preg_match('/^space-(x|y)(-reverse)?(-(.+))?$/', $class, $matches)) {
            $direction = $matches[1];
            $isReverse = isset($matches[2]) && $matches[2] === '-reverse';
            $value = $isReverse ? '0' : ($matches[4] ?? '0');
            return new self($value, $direction, $isReverse);
        }
        return null;
    }
}