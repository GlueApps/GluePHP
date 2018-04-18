<?php

namespace GlueApps\GluePHP\Tests\Unit\Extended\VueJS;

use PHPUnit\Framework\TestCase;
use GlueApps\GluePHP\Extended\VueJS\VueProcessor;
use GlueApps\ComposedViews\Asset\ScriptAsset;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class VueProcessorTest extends TestCase
{
    public function testDependsOfVueScript()
    {
        $vuejs = VueProcessor::assets()['vuejs'];

        $this->assertEquals('vuejs', $vuejs->getId());
        $this->assertInstanceOf(ScriptAsset::class, $vuejs);
    }
}
