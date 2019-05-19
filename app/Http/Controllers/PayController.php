<?php

namespace App\Http\Controllers;

class PayController extends Controller
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
    public function pay(){
        $oid = $_GET['oid'];
        $data = [
            'oid' => $oid         
        ];
        $url = env('API_PASSPORT')."/pay/pay";
        return curl($url,$data);
    }
}
