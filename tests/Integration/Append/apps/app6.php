<?php
/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

require_once 'base.php';

use GlueApps\GluePHP\Tests\Integration\Entities\Components\Button;
use GlueApps\GluePHP\Action\AlertAction;
use GlueApps\GluePHP\Component\Sidebar;

$button1->on('click', function ($event1) {
    $button2 = new Button('button2');
    $button2->on('click', function ($event2) {
        $action = new AlertAction('button2.click');
        $app = $event2->getApp();
        $app->act($action);
    });

    $sidebar = new Sidebar('sidebar');
    $sidebar->addChild($button2);

    $app = $event1->getApp();
    $app->appendComponent('body', $sidebar);
});

return $app;
