<?php

namespace GlueApps\GluePHP\Tests\Unit\Builder;

use PHPUnit\Framework\TestCase;
use GlueApps\GluePHP\AbstractApp;
use GlueApps\GluePHP\Builder\AppBuilder;
use GlueApps\ComposedViews\Builder\PageBuilder;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class AppBuilderTest extends TestCase
{
    public function setUp()
    {
        $this->builder = new AppBuilder;
        $this->xml = '<app class="GlueApps\GluePHP\Tests\Unit\Builder\App"></app>';
        $this->app = $this->builder->build($this->xml);

        $this->builder->onTag('component', function ($event) {
            $component = new Component(uniqid());
            $event->setEntity($component);
        });
    }

    public function testIsInstanceOfPageBuilder()
    {
        $this->assertInstanceOf(PageBuilder::class, $this->builder);
    }

    public function testCreateAnAppInstanceOfClassAttribute()
    {
        $this->assertInstanceOf(App::class, $this->app);
    }

    public function testHasNotControllerByDefault()
    {
        $this->assertEmpty($this->app->getControllerPath());
    }

    public function testControllerPathFromXmlControllerAttribute()
    {
        $controllerPath = uniqid();
        $xml = <<<XML
<app class="GlueApps\GluePHP\Tests\Unit\Builder\App"
      controller="{$controllerPath}"></app>
XML;
        $app = $this->builder->build($xml);

        $this->assertEquals($controllerPath, $app->getControllerPath());
    }

    public function testHasNotBasePathByDefault()
    {
        $this->assertEmpty($this->app->basePath());
    }

    public function testBasePathFromXmlBasePathAttribute()
    {
        $basePath = uniqid();
        $xml = <<<XML
<app class="GlueApps\GluePHP\Tests\Unit\Builder\App"
      base-path="{$basePath}"></app>
XML;
        $app = $this->builder->build($xml);

        $this->assertEquals($basePath, $app->basePath());
    }

    public function providerInvalidClass()
    {
        return [
            ['<app class="GlueApps\ComposedViews\Tests\Builder\Page"></app>'],
        ];
    }

    /**
     * @dataProvider providerInvalidClass
     * @expectedException GlueApps\GluePHP\Builder\Exception\InvalidAppClassException
     */
    public function testThrowLostClassAttributeException($xml)
    {
        $this->builder->build($xml);
    }

    public function testAppTagPopulation1()
    {
        $id = uniqid('comp');
        $xml = <<<XML
<app class="GlueApps\GluePHP\Tests\Unit\Builder\App">
    <sidebar id="sidebar1">
        <component id="{$id}"></component>
    </sidebar>
</app>
XML;

        $app = $this->builder->build($xml);
        $sidebar1 = $app->getSidebar('sidebar1');
        $sidebar2 = $app->getSidebar('sidebar2');
        $component = $sidebar1->getChild($id);

        $this->assertEquals($sidebar1, $component->getParent());
        $this->assertEmpty($sidebar2->getChildren());
    }

    public function testAppTagPopulation2()
    {
        $xml = <<<XML
<app class="GlueApps\GluePHP\Tests\Unit\Builder\App">

    <sidebar id="sidebar1">
        <component id="component1">
            <component id="component2"></component>
            <component id="component3"></component>
        </component>
    </sidebar>

    <sidebar id="sidebar2">
        <component id="component4">
            <component id="component5">
                <component id="component6"></component>
            </component>
        </component>
    </sidebar>

</app>
XML;

        $app = $this->builder->build($xml);

        $this->assertEquals($app->sidebar1, $app->component1->getParent());
        $this->assertEquals($app->component1, $app->component2->getParent());
        $this->assertEquals($app->component1, $app->component3->getParent());

        $this->assertEquals($app->sidebar2, $app->component4->getParent());
        $this->assertEquals($app->component4, $app->component5->getParent());
        $this->assertEquals($app->component5, $app->component6->getParent());
    }

    public function testBuildAppReturnResultOfBuildMethod()
    {
        $app = $this->createMock(AbstractApp::class);
        $xml = uniqid();

        $builder = $this->getMockBuilder(AppBuilder::class)
            ->setMethods(['build'])
            ->getMock();
        $builder->expects($this->once())
            ->method('build')
            ->with($this->equalTo($xml))
            ->willReturn($app);

        $this->assertEquals($app, $builder->buildApp($xml));
    }

    /**
     * @expectedException GlueApps\GluePHP\Builder\Exception\InvalidAppException
     */
    public function testBuildAppThrowInvalidAppExceptionIfBuiltResultIsNotAnInstanceOfApp()
    {
        $xml = '<component></component>';
        $this->builder->buildApp($xml);
    }
}
