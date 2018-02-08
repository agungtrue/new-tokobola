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
use App\Support\Response\Json;
$router->get('/', function () use ($router) {
    Json::set('message', 'WELCOME TO SUN API FOR KASBONDONG SYSTEM');
    return response()->json(Json::get(), 200);
});

$router->post('/login', ['uses' => 'Authentication\AuthenticationController@login', 'middleware' => ['Authentication.Login']]);

$router->post('/account/member', ['uses' => 'Account\AccountController@memberSignUp', 'middleware' => ['Account.MemberSignUp']]);
