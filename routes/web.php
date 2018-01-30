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

$router->get('/member', ['uses' => 'MemberController@get']);
$router->post('/member', ['uses' => 'MemberController@create', 'middleware' => ['Member.Insert']]);
$router->put('/member', ['uses' => 'MemberController@update']);
$router->delete('/member', ['uses' => 'MemberController@delete']);
