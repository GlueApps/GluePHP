<?php

namespace GlueApps\GluePHP\Tests\Unit\Extended\VueJS;

use PHPUnit\Framework\TestCase;
use GlueApps\GluePHP\Extended\VueJS\VueComponent;
use GlueApps\GluePHP\Extended\VueJS\VueProcessor;
use GlueApps\GluePHP\Processor\ShortEventsProcessor;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class VueComponentTest extends TestCase
{
    public function setUp()
    {
        $this->component = new VueComponent('component');
    }

    public function testDependsOfVueProcessor()
    {
        $this->assertContains(
            VueProcessor::class,
            $this->component->processors()
        );
    }

    public function testDependsOfShortEventsProcessor()
    {
        $this->assertContains(
            ShortEventsProcessor::class,
            $this->component->processors()
        );
    }
}
