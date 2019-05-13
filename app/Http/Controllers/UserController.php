<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Model\UserModel;
// use Illuminate\Support\Facades\Redis;

class UserController extends Controller
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

    /**
     * 注册
     */
    public function reg(Request $request){
        

    }
    /**
     * 登录
     */
    public function login(Request $request){
        // echo "<pre>";print_r($request->input());echo "</pre>";
        // $email = $request->input('email');
        // // echo Crypt::encrypt('lumen');
        // $password = $request->input('password');
        // echo $password;echo "<br>";
        var_dump($_GET['public_key']);
        $post_json = file_get_contents("php://input");
        var_dump($post_json);
        $post = json_decode(file_get_contents("php://input"),true);
        // var_dump($post);
        $email = $post['email'];
        $password = $post['password'];
        echo $password;die;
        $public_key = $post['public_key'];
        // echo $public_key;
        // echo decrypt($password);echo "<br>";
        // echo Crypt::encrypt("aa");echo "<br>";
        $pwd = Crypt::decrypt($password);echo "<br>";
        // echo decrypt($password);
        // $key="longbinpwd";
        // $service    =   new UseRedisService();
        // $result     =   $service->get($key);
        // echo $result;
        $user = UserModel::where(['email'=>$email])->first();
        // echo str_random(32);die;
        // echo "<pre>";print_r($user);echo "</pre>";
        $user_pwd = $user->password;
        if($pwd == $user_pwd){
            $response = [
                'error' => 0,
                'msg'   =>"ok"
            ];
        }else{
            $response = [
                'error' => 50010,
                'msg'   =>"密码错误"
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
    /**
     * 对称加密     解密
     */
    public function openssl_decrypt(Request $request){
        $b64 = $request->input('b64');
        $method = "AES-256-CBC";
        $key = "zxcvbnm";
        $options = OPENSSL_RAW_DATA;
        $iv = "zxcvbnm123456789";
        $de_b64 = base64_decode($b64);
        $dec_str = openssl_decrypt($de_b64,$method,$key,$options,$iv);
    }
    /**
     * 非对称加密   解密
     */
    public function pub_decrypt(){
        $json = file_get_contents("php://input");
        // 获取公钥
        $public_key = openssl_get_publickey("file:///".storage_path('app/keys/public_key.pem'));
        // 公钥解密
        openssl_public_decrypt($enc_json,$dec_json,$public_key);
    }
}
