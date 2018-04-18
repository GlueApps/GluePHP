<?php
/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

use GlueApps\GluePHP\Tests\TestApp;
use GlueApps\GluePHP\Tests\Integration\Entities\Components\Button;

$button1 = new Button('button1');

$app = new TestApp();
$app->appendComponent('body', $button1);
