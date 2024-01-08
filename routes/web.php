<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/api/login', 'AuthController@login');
$router->post('/api/register', 'AuthController@register');

// Route::group([
//     'prefix' => 'api'
// ], function ($router) {
//     $router->get('/category','CategoryController@index');
//     $router->post('/category','CategoryController@store');
//     $router->get('/category/{id}','CategoryController@show');
//     $router->put('/category/{id}','CategoryController@update');
//     $router->delete('/category/{id}','CategoryController@destroy');
// });

Route::group([
    'middleware'=>'auth',
    'prefix' => 'api'
], function ($router) {
    $router->post('/logout', 'AuthController@logout');
    $router->post('/refresh', 'AuthController@refresh');
    $router->post('/user-profile', 'AuthController@me');

    $router->get('/job','JobApplicationController@index');

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

});
