<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class CartController extends Controller
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

    public function cart(Request $request){
        $uid = $request->input('uid');
        $goods_id = $request->input('goods_id');
        $num = $request->input('num');
        $data = [
            'uid'   => $uid,
            'goods_id' => $goods_id,
            'num'   =>  $num
        ];
        $url = env('API_PASSPORT')."/cart/cart";
        return curl($url,$data);
    }
    public function cartList(Request $requests){
        $uid = $request->input('uid');
        $data = [
            'uid'   => $uid
        ];
        $url = env('API_PASSPORT')."/cart/cartList";
        return curl($url,$data);
    }
}
