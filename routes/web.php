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
// 注册登录
$router->post('/user/reg',[
    'as' => '注册',
    'uses' => 'UserController@reg'
]);
$router->post('/user/login',[
    'as' => '登录',
    'uses' => 'UserController@login'
]);
// 测试
$router->post('/openssl/decrypt',[
    'as' => '',
    'uses' => 'UserController@openssl_decrypt'
]);

// ajax测试
$router->post('/ajaxreg',[
    'as' => '注册',
    'uses' => 'UserController@ajaxreg'
]);
$router->post('/ajaxlogin',[
    'as' => '注册',
    'uses' => 'UserController@ajaxlogin'
]);

// passport注册登录（分布）
$router->post('/user/passportReg',[
    'as' => '注册',
    'uses' => 'UserController@passportReg'
]);
$router->post('/user/passportLogin',[
    'as' => '登录',
    'uses' => 'UserController@passportLogin'
]);
// 个人中心
$router->post('/home/center',[
    'as' => '注册',
    'middleware' => 'CheckToken',
    'uses' => 'HomeController@center'
]);
// 商品
$router->post('/goods/goods',[
    'as' => '注册',
    'middleware' => 'CheckToken',
    'uses' => 'GoodsController@goods'
]);
$router->post('/goods/goodsDetail',[
    'as' => '注册',
    'middleware' => 'CheckToken',
    'uses' => 'GoodsController@goodsDetail'
]);
// 购物车
$router->post('/cart/cart',[
    'as' => '注册',
    'middleware' => 'CheckToken',
    'uses' => 'CartController@cart'
]);
$router->post('/cart/cartList',[
    'as' => '注册',
    'middleware' => 'CheckToken',
    'uses' => 'CartController@cartList'
]);
// 订单
$router->post('/order/order',[
    'as' => '注册',
    'middleware' => 'CheckToken',
    'uses' => 'OrderController@order'
]);