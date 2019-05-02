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

Route::get('/users', 'UserController@index');
Route::get('/user/{id}','UserController@show');
Route::delete('/user/{id}','UserController@destroy');
Route::put('/user/{id}','UserController@update');
Route::post('/user','UserController@store');

Route::get('/posts','PostController@index');
Route::get('/post/{id}','PostController@show');

//Route::get('/user/{id}',['middleware' => 'shield','uses' => 'Usercontroller@show'])