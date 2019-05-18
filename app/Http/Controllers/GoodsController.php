<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class GoodsController extends Controller
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

    public function goods(Request $request){
        $uid = $request->input('uid');
        $data = [
            'uid'   => $uid
        ];
        $url = env('API_PASSPORT')."/goods/goods";
        return curl($url,$data);
    }
    public function goodsDetail(Request $request){
        $uid = $request->input('uid');
        $goods_id = $request->input('goods_id');
        $data = [
            'uid'   => $uid,
            'goods_id' => $goods_id
        ];
        $url = env('API_PASSPORT')."/goods/goodsDetail";
        return curl($url,$data);
    }
}
