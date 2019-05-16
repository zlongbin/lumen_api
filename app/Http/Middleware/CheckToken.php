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
            $reponse = [
                "error" => 50021,
                "msg"   =>  "参数不完整"
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $key = "login_token:uid".$_GET['uid'];
            $token = Redis::get($key);
            if($token){
                if($token != $_GET['token']){
                    $reponse = [
                        "error" => 50020,
                        "msg"   =>  "token值错误"
                    ];
                    die(json_encode($response,JSON_UNESCAPED_UNICODE));
                }
            }else{
                $reponse = [
                    "error" => 50020,
                    "msg"   =>  "token值过期"
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }
        return $next($request);
    }
}
