<?php

namespace Raakkan\PhpTailwind\Tests;

use PHPUnit\Framework\TestCase;
use Raakkan\PhpTailwind\Concerns\SpacingParser;

class SpacingParserTest extends TestCase
{
    use SpacingParser;

    public function testParseSpacing()
    {
        $classes = ['p-4', 'm-2', 'px-3', 'my-1.5', 'pt-px', 'mr-0', 'p-0.5'];
        $result = $this->parseSpacing($classes);

        $this->assertStringContainsString('.p-4{padding: 1rem;}', $result);
        $this->assertStringContainsString('.m-2{margin: 0.5rem;}', $result);
        $this->assertStringContainsString('.px-3{padding-left: 0.75rem; padding-right: 0.75rem;}', $result);
        $this->assertStringContainsString('.my-1.5{margin-top: 0.375rem; margin-bottom: 0.375rem;}', $result);
        $this->assertStringContainsString('.pt-px{padding-top: 1px;}', $result);
        $this->assertStringContainsString('.mr-0{margin-right: 0px;}', $result);
        $this->assertStringContainsString('.p-0.5{padding: 0.125rem;}', $result);
    }

    public function testCalculateValue()
    {
        $this->assertEquals('1px', $this->calculateValue('px'));
        $this->assertEquals('0px', $this->calculateValue('0'));
        $this->assertEquals('0.25rem', $this->calculateValue('1'));
        $this->assertEquals('0.375rem', $this->calculateValue('1.5'));
    }

    public function testParseSpaceClasses()
    {
        $classes = ['space-x-2', 'space-y-4', 'space-x-px', 'space-y-0.5'];
        $result = $this->parseSpaceClasses($classes);

        $this->assertStringContainsString('.space-x-2 > :not([hidden]) ~ :not([hidden]){margin-left:0.5rem;margin-right:0.5rem;}', $result);
        $this->assertStringContainsString('.space-y-4 > :not([hidden]) ~ :not([hidden]){margin-top:1rem;margin-bottom:1rem;}', $result);
        $this->assertStringContainsString('.space-x-px > :not([hidden]) ~ :not([hidden]){margin-left:1px;margin-right:1px;}', $result);
        $this->assertStringContainsString('.space-y-0.5 > :not([hidden]) ~ :not([hidden]){margin-top:0.125rem;margin-bottom:0.125rem;}', $result);
    }
}