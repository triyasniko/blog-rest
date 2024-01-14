<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/api/login', 'AuthController@login');
$router->post('/api/register', 'AuthController@register');

Route::group([
    'middleware'=>'auth',
    'prefix' => 'api'
], function ($router) {
    $router->post('/logout', 'AuthController@logout');
    $router->post('/refresh', 'AuthController@refresh');
    $router->post('/user-profile', 'AuthController@me');

    $router->get('/job','JobApplicationController@index');
    $router->post('/job','JobApplicationController@store');
    $router->put('/job/{id}','JobApplicationController@update');
    $router->get('/job/{id}','JobApplicationController@show');
    $router->delete('/job/{id}','JobApplicationController@destroy');

    $router->get('/position','PositionController@index');
    $router->post('/position','PositionController@store');
    $router->put('/position/{id}','PositionController@update');
    $router->get('/position/{id}','PositionController@show');
    $router->delete('/position/{id}','PositionController@destroy');

    $router->get('/company','CompanySectorController@index');
    $router->post('/company','CompanySectorController@store');
    $router->put('/company/{id}','CompanySectorController@update');
    $router->get('/company/{id}','CompanySectorController@show');
    $router->delete('/company/{id}','CompanySectorController@destroy');

    $router->get('/notification','NotificationController@index');
    $router->get('/notification/{id}','NotificationController@show');
    $router->delete('/notification/{id}','NotificationController@destroy');
});
