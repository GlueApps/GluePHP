<?php

namespace GlueApps\GluePHP\Tests\Unit\Response;

use GlueApps\GluePHP\Action\AbstractAction;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class DummyAction extends AbstractAction
{
    public static function handlerScript(): string
    {
        return '';
    }
}
