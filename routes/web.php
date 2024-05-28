<?php

/** @var \Laravel\Lumen\Routing\Router $router */


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

// user authentication routes
$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@store');

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['middleware' => ['auth', 'token', 'api-key' , 'ip-whiteList']], function () use ($router) {
        $router->get('questions', 'QuestionController@index');
        $router->post('questions', 'QuestionController@store');
        $router->get('questions/{id}', 'QuestionController@show');
        $router->put('questions/{id}', 'QuestionController@update');
        $router->delete('questions/{id}', 'QuestionController@destroy');
    });

    $router->get('/ban-user/{id}', 'UserController@ban');
});
