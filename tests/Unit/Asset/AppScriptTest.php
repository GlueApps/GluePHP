<?php

namespace GlueApps\GluePHP\Tests\Unit\Asset;

use PHPUnit\Framework\TestCase;
use GlueApps\GluePHP\AbstractApp;
use GlueApps\GluePHP\Asset\AppScript;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class AppScriptTest extends TestCase
{
    public function testInvokeToUpdateComponentClassesOnApp()
    {
        $app = $this->getMockBuilder(AbstractApp::class)
            ->setConstructorArgs([''])
            ->setMethods(['updateComponentClasses'])
            ->getMockForAbstractClass();
        $app->expects($this->once())
            ->method('updateComponentClasses');

        $script = new AppScript('script', $app);
        $script->html();
    }

    public function testInvokeToUpdateProcessorClassesOnApp()
    {
        $app = $this->getMockBuilder(AbstractApp::class)
            ->setConstructorArgs([''])
            ->setMethods(['updateProcessorClasses'])
            ->getMockForAbstractClass();
        $app->expects($this->once())
            ->method('updateProcessorClasses');

        $script = new AppScript('script', $app);
        $script->html();
    }
}
