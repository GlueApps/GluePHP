<?php

namespace GlueApps\GluePHP\Action;

use GlueApps\GluePHP\Action\AbstractAction;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class RegisterAction extends AbstractAction
{
    protected $actionClass;

    public function __construct(string $actionClass, string $handlerId)
    {
        $this->actionClass = $actionClass;

        $handler = $actionClass::handlerScriptWrapper();

        parent::__construct([
            'id'      => $handlerId,
            'handler' => $handler,
        ]);
    }

    public function getActionClass(): string
    {
        return $this->actionClass;
    }

    public static function handlerScript(): string
    {
        return <<<JAVASCRIPT
    var str = 'app.actionHandlers.' + data.id + ' = ' + data.handler;
    eval(str);
JAVASCRIPT;
    }
}
