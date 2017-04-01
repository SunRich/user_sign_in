<?php

$app->group(['prefix' => 'v1'], function () use ($app) {
    $app->get('signins','SignController@index');

    $app->post('signins','SignController@signin');
});