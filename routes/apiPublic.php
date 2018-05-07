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

$router->get('/provinces', ['uses' => 'Administrative\AdministrativeController@provinces', 'middleware' => ['ArrQuery']]);
$router->get('/provinces/{query:.+}', ['uses' => 'Administrative\AdministrativeController@provinces', 'middleware' => ['ArrQuery']]);
$router->get('/regencies', ['uses' => 'Administrative\AdministrativeController@regencies', 'middleware' => ['ArrQuery']]);
$router->get('/regencies/{query:.+}', ['uses' => 'Administrative\AdministrativeController@regencies', 'middleware' => ['ArrQuery']]);
$router->get('/districts', ['uses' => 'Administrative\AdministrativeController@districts', 'middleware' => ['ArrQuery']]);
$router->get('/districts/{query:.+}', ['uses' => 'Administrative\AdministrativeController@districts', 'middleware' => ['ArrQuery']]);
$router->get('/villages', ['uses' => 'Administrative\AdministrativeController@villages', 'middleware' => ['ArrQuery']]);
$router->get('/villages/{query:.+}', ['uses' => 'Administrative\AdministrativeController@villages', 'middleware' => ['ArrQuery']]);

// Company
$router->get('/company', ['uses' => 'Company\CompanyController@get', 'middleware' => ['ArrQuery']]);
$router->get('/company/{query:.+}', ['uses' => 'Company\CompanyController@get', 'middleware' => ['ArrQuery']]);
