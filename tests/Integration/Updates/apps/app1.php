<?php

require_once 'base.php';

$app->on('button.click', function ($event) {
    $app = $event->getApp();
    $input1 = $app->input1;
    $input2 = $app->input2;
    $input2->setText($input1->getText());
});

return $app;
