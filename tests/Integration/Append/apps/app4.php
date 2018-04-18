<?php
/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

require_once 'base.php';

use GlueApps\GluePHP\Component\Sidebar;
use GlueApps\GluePHP\Tests\Integration\Entities\Components\Button;

$button1->on('click', function ($event) {
    $app = $event->getApp();

    $button2 = new Button('button2');
    $sidebar = new Sidebar('sidebar');
    $sidebar->addChild($button2);

    $app->appendComponent('body', $sidebar);
});

return $app;
