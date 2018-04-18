<?php
/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

use GlueApps\GluePHP\Tests\TestApp;
use GlueApps\GluePHP\Tests\Integration\Entities\Components\TextInput;
use GlueApps\GluePHP\Tests\Integration\Entities\Components\Button;

$input1 = new TextInput('input1');
$input2 = new TextInput('input2');
$button = new Button('button');

$app = new TestApp();
$app->appendComponent('body', $input1);
$app->appendComponent('body', $input2);
$app->appendComponent('body', $button);
