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
$router->put('/memberfromcms/id/{id}', ['uses' => 'Users\MemberController@updatecms']);
$router->delete('/member/id/{id}', ['uses' => 'Users\MemberController@delete']);

//blog
$router->get('/blog', ['uses' => 'Blog\BlogController@get', 'middleware' => ['ArrQuery']]);
$router->get('/blog/{query:.+}', ['uses' => 'Blog\BlogController@get', 'middleware' => ['ArrQuery']]);
$router->post('/blog', ['uses' => 'Blog\BlogController@create', 'middleware' => ['Blog.Insert']]);
$router->put('/blog/id/{id}', ['uses' => 'Blog\BlogController@update', 'middleware' => ['Blog.Update']]);
$router->delete('/blog/id/{id}', ['uses' => 'Blog\BlogController@delete']);

//order
$router->get('/order', ['uses' => 'Order\OrderController@get', 'middleware' => ['ArrQuery']]);
$router->get('/order/{query:.+}', ['uses' => 'Order\OrderController@get', 'middleware' => ['ArrQuery']]);
$router->post('/order', ['uses' => 'Order\OrderController@create', 'middleware' => ['Order.Insert']]);
$router->put('/order/order_id/{id}', ['uses' => 'Order\OrderController@update', 'middleware' => ['Order.Update']]);
$router->delete('/order/id/{id}', ['uses' => 'Order\OrderController@delete']);

//orderDetail
$router->get('/orderDetail', ['uses' => 'OrderDetail\OrderDetailController@get', 'middleware' => ['ArrQuery']]);
$router->get('/orderDetail/{query:.+}', ['uses' => 'OrderDetail\OrderDetailController@get', 'middleware' => ['ArrQuery']]);

//iklan
$router->get('/iklan', ['uses' => 'Iklan\IklanController@get', 'middleware' => ['ArrQuery']]);
$router->get('/iklan/{query:.+}', ['uses' => 'Iklan\IklanController@get', 'middleware' => ['ArrQuery']]);
$router->post('/iklan', ['uses' => 'Iklan\IklanController@create', 'middleware' => ['Iklan.Insert']]);
$router->put('/iklan/id/{id}', ['uses' => 'Iklan\IklanController@update', 'middleware' => ['Iklan.Update']]);
$router->delete('/iklan/id/{id}', ['uses' => 'Iklan\IklanController@delete']);

//produk
$router->get('/produk', ['uses' => 'Produk\ProdukController@get', 'middleware' => ['ArrQuery']]);
$router->get('/produk/{query:.+}', ['uses' => 'Produk\ProdukController@get', 'middleware' => ['ArrQuery']]);
$router->post('/produk', ['uses' => 'Produk\ProdukController@create', 'middleware' => ['Produk.Insert']]);
$router->put('/produk/id/{id}', ['uses' => 'Produk\ProdukController@update', 'middleware' => ['Produk.Update']]);
$router->delete('/produk/id/{id}', ['uses' => 'Produk\ProdukController@delete']);

//kategori
$router->get('/kategori', ['uses' => 'Kategori\KategoriController@get', 'middleware' => ['ArrQuery']]);
$router->get('/kategori/{query:.+}', ['uses' => 'Kategori\KategoriController@get', 'middleware' => ['ArrQuery']]);
$router->post('/kategori', ['uses' => 'Kategori\KategoriController@create', 'middleware' => ['Kategori.Insert']]);
$router->put('/kategori/id/{id}', ['uses' => 'Kategori\KategoriController@update', 'middleware' => ['Kategori.Update']]);
$router->delete('/kategori/id/{id}', ['uses' => 'Kategori\KategoriController@delete']);

//keranjang
$router->get('/keranjang', ['uses' => 'Keranjang\KeranjangController@get', 'middleware' => ['ArrQuery']]);
$router->get('/keranjang/{query:.+}', ['uses' => 'Keranjang\KeranjangController@get', 'middleware' => ['ArrQuery']]);
$router->post('/keranjang', ['uses' => 'Keranjang\KeranjangController@create', 'middleware' => ['Keranjang.Insert']]);
$router->put('/keranjang/id/{id}', ['uses' => 'Keranjang\KeranjangController@update', 'middleware' => ['Keranjang.Update']]);
$router->delete('/keranjang/id/{id}', ['uses' => 'Keranjang\KeranjangController@delete']);

// //Clubs
// $router->get('/club', ['uses' => 'Club\ClubController@get', 'middleware' => ['ArrQuery']]);
// $router->get('/club/{query:.+}', ['uses' => 'Club\ClubController@get', 'middleware' => ['ArrQuery']]);
// $router->post('/club', ['uses' => 'Club\ClubController@create', 'middleware' => ['Club.Insert']]);
// $router->put('/club/id/{id}', ['uses' => 'Club\ClubController@update', 'middleware' => ['Club.Update']]);
// $router->delete('/club/id/{id}', ['uses' => 'Club\ClubController@delete']);
//
// //Liga
// $router->get('/liga', ['uses' => 'Liga\LigaController@get', 'middleware' => ['ArrQuery']]);
// $router->get('/liga/{query:.+}', ['uses' => 'Liga\LigaController@get', 'middleware' => ['ArrQuery']]);
// $router->post('/liga', ['uses' => 'Liga\LigaController@create', 'middleware' => ['Liga.Insert']]);
// $router->put('/liga/id/{id}', ['uses' => 'Liga\LigaController@update', 'middleware' => ['Liga.Update']]);
// $router->delete('/liga/id/{id}', ['uses' => 'Liga\LigaController@delete']);
//
// //Negara
// $router->get('/negara', ['uses' => 'Negara\NegaraController@get', 'middleware' => ['ArrQuery']]);
// $router->get('/negara/{query:.+}', ['uses' => 'Negara\NegaraController@get', 'middleware' => ['ArrQuery']]);
// $router->post('/negara', ['uses' => 'Negara\NegaraController@create', 'middleware' => ['Negara.Insert']]);
// $router->put('/negara/id/{id}', ['uses' => 'Negara\NegaraController@update', 'middleware' => ['Negara.Update']]);
// $router->delete('/negara/id/{id}', ['uses' => 'Negara\NegaraController@delete']);


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
