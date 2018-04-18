<?php
/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

require_once 'base.php';

use GlueApps\GluePHP\Tests\Integration\Entities\Components\TextInput;

$button1->on('click', function ($event) {
    $input = new TextInput('input');
    $input->setText('secret');

    $app = $event->getApp();
    $app->appendComponent('body', $input);
});

return $app;
