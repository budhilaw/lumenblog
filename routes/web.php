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

/*
|----------------------
| Dummy Option
|----------------------
|
| Generate a dummy data for login
*/
$router->get('/test', 'UserController@test');

/*
|----------------------
| Login Application
|----------------------
|
| Generate a new token for accessing other features
*/
$router->post('/login', 'AuthController@authenticate');


/*
|----------------------
| Users Features
|----------------------
*/
$router->group(['middleware' => 'jwt.auth'], function() use ($router) {
    $router->post('/user', 'UserController@index');
    $router->post('/user/show', 'UserController@index');

    $router->post('/user/new', 'UserController@create');
    $router->post('/user/show/{id}', 'UserController@show');
    $router->post('/user/edit/{id}', 'UserController@edit');
});
