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
$router->post('/user/reg',[
    'as' => '注册',
    'uses' => 'UserController@reg'
]);
$router->post('/user/login',[
    'as' => '登录',
    'uses' => 'UserController@login'
]);
$router->post('/openssl/decrypt',[
    'as' => '',
    'uses' => 'UserController@openssl_decrypt'
]);
$router->get('/ajax',[
    'as' => '注册',
    'uses' => 'UserController@ajax'
]);