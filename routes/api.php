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

$router->get('/user', ['uses' => 'User\UserController@get', 'middleware' => ['ArrQuery']]);
$router->get('/user/{query:.+}', ['uses' => 'User\UserController@get', 'middleware' => ['ArrQuery']]);
$router->post('/user', ['uses' => 'User\UserController@create', 'middleware' => ['User.Insert']]);
$router->put('/user/id/{id}', ['uses' => 'User\UserController@update']);

//member
$router->get('/member', ['uses' => 'Users\MemberController@get', 'middleware' => ['ArrQuery']]);
$router->get('/member/{query:.+}', ['uses' => 'Users\MemberController@get', 'middleware' => ['ArrQuery']]);
$router->post('/member', ['uses' => 'Users\MemberController@create', 'middleware' => ['Member.Insert']]);
$router->put('/member/id/{id}', ['uses' => 'Users\MemberController@update']);
$router->delete('/member/id/{id}', ['uses' => 'Users\MemberController@delete']);

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


// $router->get('/member', ['uses' => 'Member\MemberController@get', 'middleware' => ['ArrQuery']]);
// $router->get('/member/{query:.+}', ['uses' => 'Member\MemberController@get', 'middleware' => ['ArrQuery']]);
// $router->post('/member', ['uses' => 'Member\MemberController@create', 'middleware' => ['Member.Insert']]);
// $router->put('/member/id/{id}', ['uses' => 'Member\MemberController@update']);
// $router->put('/member/my', ['uses' => 'Member\MemberController@updateMy', 'middleware' => ['Member.UpdateMy']]);
// $router->delete('/member/id/{id}', ['uses' => 'Member\MemberController@delete']);

$router->get('/loan', ['uses' => 'Loan\LoanController@get', 'middleware' => ['ArrQuery']]);
$router->get('/loan/{query:.+}', ['uses' => 'Loan\LoanController@get', 'middleware' => ['ArrQuery']]);
$router->post('/loan', ['uses' => 'Loan\LoanController@create', 'middleware' => ['Loan.Insert']]);
$router->put('/loan/id/{id}', ['uses' => 'Loan\LoanController@update']);
$router->delete('/loan/id/{id}', ['uses' => 'Loan\LoanController@delete']);


$router->post('/image', ['uses' => 'Image\ImageController@upload', 'middleware' => ['Image.Upload']]);


/**
 * Company
 */
$router->post('/company', ['uses' => 'Company\CompanyController@create', 'middleware' => ['Company.Insert']]);
$router->delete('/company/id/{id}', ['uses' => 'Company\CompanyController@delete']);
$router->put('/company/id/{id}', ['uses' => 'Company\CompanyController@update']);
