<?php

namespace GlueApps\GluePHP\Action;

use GlueApps\GluePHP\Action\AbstractAction;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class RegisterEventAction extends AbstractAction
{
    public function __construct(string $eventName, array $eventData)
    {
        parent::__construct([
            'eventName' => $eventName,
            'eventData' => $eventData,
        ]);
    }

    public static function handlerScript(): string
    {
        return <<<JAVASCRIPT
    app.registerEvent(data.eventName, data.eventData);
JAVASCRIPT;
    }
}
