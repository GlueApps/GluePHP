<?php

namespace GlueApps\GluePHP\Component;

use PHPUnit\Framework\TestCase;
use GlueApps\GluePHP\Component\Sidebar;
use GlueApps\ComposedViews\Component\SidebarInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class SidebarTest extends TestCase
{
    public function setUp()
    {
        $this->sidebar = new Sidebar;
    }

    public function testProcessors_ReturnAnEmptyArray()
    {
        $this->assertEquals([], $this->sidebar->processors());
    }

    public function testIsInstanceOfComposedViewSidebarInterface()
    {
        $this->assertInstanceOf(SidebarInterface::class, $this->sidebar);
    }
}
