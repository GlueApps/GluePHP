<?php

namespace GlueApps\GluePHP\Tests\Unit\Action;

use GlueApps\GluePHP\Action\AbstractAction;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class DummyAction1 extends AbstractAction
{
    public static function handlerScript(): string
    {
        return '';
    }
}
