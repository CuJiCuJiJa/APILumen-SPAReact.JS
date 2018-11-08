<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/user/login', ['uses' => 'UserController@getToken']);
$router->get('/users', ['uses' => 'UserController@index']);
$router->post('/user', ['uses' => 'UserController@create']);
$router->get('/user/{id}', ['uses' => 'UserController@show']);
$router->delete('/user/{id}', ['uses' => 'UserController@destroy']);