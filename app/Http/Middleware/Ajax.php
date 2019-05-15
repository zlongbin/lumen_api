<?php

namespace App\Http\Middleware;

use Closure;

class Ajax
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
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 200);
        } else {
            $response = $next($request);
        }
        echo "<pre>";print_r($response);echo "</pre>";echo "<hr>";
        var_dump($response);
        if (!method_exists($response, 'header')) {
            return $response;
        }
        $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS');
        $response->header(
            'Access-Control-Allow-Headers',
            'Content-Type, Content-Length, Authorization, Accept, X-Requested-With, Token'
        );
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Max-Age', 86400);
        return $response;
        return $next($request);
    }
}
