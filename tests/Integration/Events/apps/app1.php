<?php
/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */

require_once 'base.php';

$app->appendComponent('body', $input);

$input->on('keypress', $callback, ['key', 'charCode']);

return $app;
