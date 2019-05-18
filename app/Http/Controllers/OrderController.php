<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class OrderController extends Controller
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

    public function order(Request $request){
        $uid = $request->input('uid');
        $token = $request->input('token');
        $data = [
            'uid'   => $uid,
            'token' => $token
        ];
        $url = env('API_PASSPORT')."/order/order";
        return curl($url,$data);
    }
}
