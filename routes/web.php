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

    $router->get('/article','ArticleController@index');
    $router->post('/article','ArticleController@store');
    $router->put('/article/{id}','ArticleController@update');
    $router->get('/article/{id}','ArticleController@show');
    $router->delete('/article/{id}','ArticleController@destroy');

    $router->get('/tag','TagController@index');
    $router->post('/tag','TagController@store');
    $router->put('/tag/{id}','TagController@update');
    $router->get('/tag/{id}','TagController@show');
    $router->delete('/tag/{id}','TagController@destroy');

    $router->get('/category','CategoryController@index');
    $router->post('/category','CategoryController@store');
    $router->put('/category/{id}','CategoryController@update');
    $router->get('/category/{id}','CategoryController@show');
    $router->delete('/category/{id}','CategoryController@destroy');

    $router->get('/notification','NotificationController@index');
    $router->get('/notification/{id}','NotificationController@show');
    $router->delete('/notification/{id}','NotificationController@destroy');
});
