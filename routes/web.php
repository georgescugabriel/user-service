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

$router->get('/status/_info', 'HealthCheckController@info');
$router->get('/status/_health', 'HealthCheckController@health');

$router->group(['prefix' => 'auth'], function ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('login-business', 'AuthController@loginBusiness');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('me', 'AuthController@me');
});
$router->get('/', 'MainController@index');
$router->post('/', 'MainController@store');
$router->get('/{key}', 'MainController@show');
$router->put('/{key}', 'MainController@update');
$router->delete('/{key}', 'MainController@destroy');
$router->post('/login-business', 'MainController@loginBusiness');
$router->post('/login-client', 'MainController@loginClient');
