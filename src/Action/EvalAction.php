<?php

namespace GlueApps\GluePHP\Action;

use GlueApps\GluePHP\Action\AbstractAction;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class EvalAction extends AbstractAction
{
    public static function handlerScript(): string
    {
        return 'eval(data);';
    }
}
