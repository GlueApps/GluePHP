<?php
/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

use Andaniel05\GluePHP\Tests\TestApp;
use Andaniel05\GluePHP\Tests\Integration\Entities\Components\VueButton;

$text = $_GET['text'];
$button = new VueButton('button');
$button->setText($text);

$app = new TestApp();
$app->appendComponent('body', $button);

return $app;
