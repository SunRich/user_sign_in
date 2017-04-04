<?php

$app->group(['prefix' => 'v1'], function () use ($app) {
    $app->get('users/{userId}/startTime/{startTime}/endTime/{endTime}','SignController@index');

    $app->post('signins','SignController@signin');
});