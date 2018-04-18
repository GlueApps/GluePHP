<?php

namespace GlueApps\GluePHP\Tests\Integration\DynamicRegistration;

use GlueApps\GluePHP\Tests\StaticTestCase;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class DynamicRegistrationStaticTest extends StaticTestCase
{
    public function clickButton($app)
    {
        $this->driver->get(appUri($app));

        $this->button = $this->driver->findElement(
            \WebDriverBy::cssSelector('#gphp-button button')
        );
        $this->button->click(); // Act
    }

    public function testRegisterActionClass()
    {
        $this->clickButton(__DIR__ . '/apps/app1.php');
        $this->waitForResponse();

        $secret = uniqid();
        $this->script("app.actionHandlers['alert']('$secret')");
        $this->assertEquals($secret, $this->driver->switchTo()->alert()->getText());
        $this->driver->switchTo()->alert()->accept();
    }

    public function testRegisterComponentClass()
    {
        $this->clickButton(__DIR__ . '/apps/app2.php');
        $this->waitForResponse();

        $id = uniqid();
        $component = $this->script("return new app.componentClasses.input('$id')");

        $this->assertEquals($id, $component['id']);
    }

    public function testTheUnknowActionsAreRegisteringDynamically()
    {
        $this->clickButton(__DIR__ . '/apps/app3.php');

        $this->driver->wait()->until(
            \WebDriverExpectedCondition::alertIsPresent()
        );

        $this->assertEquals('secret', $this->driver->switchTo()->alert()->getText());
        $this->driver->switchTo()->alert()->accept();
    }

    public function testRegisterProcessorClass()
    {
        $this->clickButton(__DIR__ . '/apps/app4.php');
        $this->waitForResponse();

        $this->script("app.processors.processor(app.getComponent('button'))");

        $this->assertEquals('secret', $this->script("return app.getComponent('button').secret"));
    }
}
