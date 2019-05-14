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
//跨域
$router->options('/{all}', function (Request $request) {
    $origin = $request->header('ORIGIN', '*');
   // header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Access-Control-Request-Headers, SERVER_NAME, Access-Control-Allow-Headers, cache-control, token, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie');
})->where(['all' => '([a-zA-Z0-9-]|/)+']);

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/user/reg',[
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