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

$router->get('/member', ['uses' => 'Member\MemberController@get', 'middleware' => ['ArrQuery']]);
$router->get('/member/{query:.+}', ['uses' => 'Member\MemberController@get', 'middleware' => ['ArrQuery']]);
$router->post('/member', ['uses' => 'Member\MemberController@create', 'middleware' => ['Member.Insert']]);
$router->put('/member', ['uses' => 'Member\MemberController@update']);
$router->put('/member/my', ['uses' => 'Member\MemberController@updateMy', 'middleware' => ['Member.UpdateMy']]);
$router->delete('/member', ['uses' => 'Member\MemberController@delete']);

$router->get('/loan', ['uses' => 'Loan\LoanController@get', 'middleware' => ['ArrQuery']]);
$router->get('/loan/{query:.+}', ['uses' => 'Loan\LoanController@get', 'middleware' => ['ArrQuery']]);
$router->post('/loan', ['uses' => 'Loan\LoanController@create', 'middleware' => ['Loan.Insert']]);

$router->post('/image', ['uses' => 'Image\ImageController@upload', 'middleware' => ['Image.Upload']]);
