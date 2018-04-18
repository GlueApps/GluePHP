<?php

namespace GlueApps\GluePHP\Action;

use GlueApps\GluePHP\Action\AbstractAction;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class AlertAction extends AbstractAction
{
    public static function handlerScript(): string
    {
        return "alert(data);";
    }
}
