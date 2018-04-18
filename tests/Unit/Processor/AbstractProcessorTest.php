<?php

namespace GlueApps\GluePHP\Tests\Unit\Processor;

use PHPUnit\Framework\TestCase;
use GlueApps\GluePHP\Processor\AbstractProcessor;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class AbstractProcessorTest extends TestCase
{
    public function testAssetReturnAnEmptyArrayByDefault()
    {
        $this->assertEquals([], AbstractProcessor::assets());
    }
}
