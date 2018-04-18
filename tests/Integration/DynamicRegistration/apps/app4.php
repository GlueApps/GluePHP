<?php
/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

require_once 'base.php';

$button->on('click', function ($event) {
    $processor = new class extends GlueApps\GluePHP\Processor\AbstractProcessor {
        public static function script(): string
        {
            return <<<JAVASCRIPT
    component.secret = 'secret';
JAVASCRIPT;
        }
    };

    $app = $event->getApp();
    $app->registerProcessorClass(get_class($processor), 'processor');
});

return $app;
