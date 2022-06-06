<?php

/** @var App\Routing\Router $router */

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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/user/register', 'UserController@register');
    $router->post('/user/sign-in', 'UserController@signIn');
    $router->match(['post', 'patch'], '/user/recover-password', 'UserController@recoverPassword');

    $router->get('/user/companies',  ['middleware' => 'auth:api', 'uses' => 'UserController@getCompanies']);
    $router->post('/user/companies',  ['middleware' => 'auth:api', 'uses' => 'UserController@addCompany']);
});
