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
    Json::set('message', 'WELCOME TO SUN API FOR TOKOBOLA SYSTEM');
    return response()->json(Json::get(), 200);
});

$router->post('/login', ['uses' => 'Authentication\AuthenticationController@login', 'middleware' => ['Authentication.Login']]);

$router->post('/account/member', ['uses' => 'Account\AccountController@memberSignUp', 'middleware' => ['Account.MemberSignUp']]);
$router->put('/account/member/id/{id}', ['uses' => 'Account\AccountController@update']);

$router->get('/provinces', ['uses' => 'Administrative\AdministrativeController@provinces', 'middleware' => ['ArrQuery']]);
$router->get('/provinces/{query:.+}', ['uses' => 'Administrative\AdministrativeController@provinces', 'middleware' => ['ArrQuery']]);
$router->get('/regencies', ['uses' => 'Administrative\AdministrativeController@regencies', 'middleware' => ['ArrQuery']]);
$router->get('/regencies/{query:.+}', ['uses' => 'Administrative\AdministrativeController@regencies', 'middleware' => ['ArrQuery']]);
$router->get('/districts', ['uses' => 'Administrative\AdministrativeController@districts', 'middleware' => ['ArrQuery']]);
$router->get('/districts/{query:.+}', ['uses' => 'Administrative\AdministrativeController@districts', 'middleware' => ['ArrQuery']]);
$router->get('/villages', ['uses' => 'Administrative\AdministrativeController@villages', 'middleware' => ['ArrQuery']]);
$router->get('/villages/{query:.+}', ['uses' => 'Administrative\AdministrativeController@villages', 'middleware' => ['ArrQuery']]);

// $router->get('/liga/{query:.+}', ['uses' => 'Liga\LigaController@ligaselected', 'middleware' => ['ArrQuery']]);

// Company
$router->get('/company', ['uses' => 'Company\CompanyController@get', 'middleware' => ['ArrQuery']]);
$router->get('/company/{query:.+}', ['uses' => 'Company\CompanyController@get', 'middleware' => ['ArrQuery']]);

//Clubs
$router->get('/club', ['uses' => 'Club\ClubController@get', 'middleware' => ['ArrQuery']]);
$router->get('/club/{query:.+}', ['uses' => 'Club\ClubController@get', 'middleware' => ['ArrQuery']]);
$router->post('/club', ['uses' => 'Club\ClubController@create', 'middleware' => ['Club.Insert']]);
$router->put('/club/id/{id}', ['uses' => 'Club\ClubController@update', 'middleware' => ['Club.Update']]);
$router->delete('/club/id/{id}', ['uses' => 'Club\ClubController@delete']);

//Liga
$router->get('/liga', ['uses' => 'Liga\LigaController@get', 'middleware' => ['ArrQuery']]);
$router->get('/liga/{query:.+}', ['uses' => 'Liga\LigaController@get', 'middleware' => ['ArrQuery']]);
$router->post('/liga', ['uses' => 'Liga\LigaController@create', 'middleware' => ['Liga.Insert']]);
$router->put('/liga/id/{id}', ['uses' => 'Liga\LigaController@update', 'middleware' => ['Liga.Update']]);
$router->delete('/liga/id/{id}', ['uses' => 'Liga\LigaController@delete']);

//Negara
$router->get('/negara', ['uses' => 'Negara\NegaraController@get', 'middleware' => ['ArrQuery']]);
$router->get('/negara/{query:.+}', ['uses' => 'Negara\NegaraController@get', 'middleware' => ['ArrQuery']]);
$router->post('/negara', ['uses' => 'Negara\NegaraController@create', 'middleware' => ['Negara.Insert']]);
$router->put('/negara/id/{id}', ['uses' => 'Negara\NegaraController@update', 'middleware' => ['Negara.Update']]);
$router->delete('/negara/id/{id}', ['uses' => 'Negara\NegaraController@delete']);
