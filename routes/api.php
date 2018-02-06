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

$router->get('/member', ['uses' => 'Member\MemberController@get', 'middleware' => ['ArrQuery']]);
$router->get('/member/{query:.+}', ['uses' => 'Member\MemberController@get', 'middleware' => ['ArrQuery']]);
$router->post('/member', ['uses' => 'Member\MemberController@create', 'middleware' => ['Member.Insert']]);
$router->put('/member', ['uses' => 'Member\MemberController@update']);
$router->delete('/member', ['uses' => 'Member\MemberController@delete']);

$router->post('/image', ['uses' => 'Image\ImageController@upload', 'middleware' => ['Image.Upload']]);
