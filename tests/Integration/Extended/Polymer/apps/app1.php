<?php
/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

use GlueApps\GluePHP\Tests\Unit\Extended\Polymer\TestApp;
use GlueApps\GluePHP\Extended\Polymer\WebComponent;
use GlueApps\GluePHP\Action\AlertAction;

$eventName = $_GET['eventName'];

$component = new WebComponent('component', 'my-tag', '');
setAttr([$eventName], 'bindEvents', $component);
$component->on($eventName, function ($ev) use ($eventName) {
    $ev->app->act(new AlertAction($eventName));
});

$app = new TestApp();
$app->appendComponent('body', $component);

return $app;
