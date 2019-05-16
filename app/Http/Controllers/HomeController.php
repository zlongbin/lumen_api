<?php

namespace App\Http\Controllers;
header('Access-Control-Allow-Origin:*');
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function center(Request $request){
        $uid = $request->input('uid');
        $token = $request->input('token');
        $data = [
            'uid'   => $uid,
            'token' => $token
        ];
        $url = "http://apitest.yxxmmm.com/home/center";
        return curl($url,$data);
    }
}
