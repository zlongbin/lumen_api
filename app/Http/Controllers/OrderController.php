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
        $goods_id = $request->input('goods_id');
        $data = [
            'uid'   => $uid,
            'goods_id'=>$goods_id
        ];
        $url = env('API_PASSPORT')."/order/order";
        return curl($url,$data);
    }
}
