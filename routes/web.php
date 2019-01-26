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
    $router->get('/user', 'UserController@index');
    $router->get('/user/show', 'UserController@index');
    $router->get('/user/show/{id}', 'UserController@show');

    $router->post('/user/new', 'UserController@create');
    $router->post('/user/edit/{id}', 'UserController@edit');
});

/*
|----------------------
| Posts Features
|----------------------
*/
$router->group(['middleware' => 'jwt.auth'], function() use ($router) {
    $router->get('/post/test/{id}', 'PostController@test');
    $router->get('/post/show/{id}', 'PostController@show');

    $router->post('/post/new', 'PostController@create');
    $router->post('/post/edit/{id}', 'PostController@edit');
    $router->delete('/post/delete/{id}', 'PostController@delete');
});
