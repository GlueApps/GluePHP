<?php
/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

use GlueApps\GluePHP\Tests\TestApp;
use GlueApps\GluePHP\Tests\Integration\Entities\Components\TextInput;
use GlueApps\GluePHP\Action\AlertAction;

$callback = function ($event) {
    $eventData = $event->getData();
    $msg = $eventData['key'] . $eventData['charCode'];
    $event->app->act(new AlertAction($msg));
};

$input = new TextInput('input');
$app = new TestApp();
