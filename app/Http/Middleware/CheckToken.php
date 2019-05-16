<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;

use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!isset($_GET['uid']) || !isset($_GET['token'])){
            $response = [
                "error" => 50021,
                "msg"   =>  "参数不完整"
            ];
            return $response;
        }else{
            // $key ="laravel_database_login_token:uid".$_GET['uid'];
            // $token = Redis::get($key);
            // // echo $token;echo "<hr>";
            // if($token){
            //     if($token != $_GET['token']){
            //         $response = [
            //             "error" => 50021,
            //             "msg"   =>  "token值错误"
            //         ];
            //         return $response;
            //     }
            // }else{
            //     $response = [
            //         "error" => 50020,
            //         "msg"   =>  "token值过期"
            //     ];
            //     return $response;
            // }
        }
        return $next($request);
    }
}
