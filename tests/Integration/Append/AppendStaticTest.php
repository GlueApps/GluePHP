<?php

namespace Andaniel05\GluePHP\Tests\Integration\Append;

use Andaniel05\GluePHP\Tests\StaticTestCase;

class AppendStaticTest extends StaticTestCase
{
    public function test1()
    {
        $this->driver->get(appUrl(__DIR__ . '/apps/app1.php'));
        $button1 = $this->driver->findElement(
            \WebDriverBy::cssSelector('#cv-button1 button')
        );

        $button1->click(); // Act
        $this->waitForResponse();

        $button2 = $this->driver->findElement(
            \WebDriverBy::cssSelector('#cv-button2 button')
        );
        $this->assertInstanceOf(\RemoteWebElement::class, $button2);
    }
}