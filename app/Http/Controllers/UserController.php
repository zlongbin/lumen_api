<?php

namespace App\Http\Controllers;
// header('Access-Control-Allow-Origin:*');
// header('Access-Control-Allow-Methods:*');
// header('Access-Control-Allow-Headers:*');
// header("Access-Control-Request-Headers:*");
// header('Access-Control-Max-Age:600');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Model\UserModel;
use App\Http\Model\AjaxUserModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

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
    public function passportReg(Request $request){
        $account = $request->input('account');
        $password = $request->input('password');
        $email = $request->input('email');
        $data = [
            'account' => $account,
            'password' => $password,
            'email' => $email            
        ];
        $url = "http://apitest.yxxmmm.com/user/passportReg";
        return curl($url,$data);
    }
    /**
     * 登录
     */
    public function passportLogin(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $data = [
            'email' => $email,
            'password' => $password
        ];
        $url = "http://apitest.yxxmmm.com/user/passportLogin";
        return curl($url,$data);
    }

    /**
     * 注册
     */
    public function reg(Request $request){
        // 接收数据
        $post_data = json_decode(file_get_contents("php://input"));
        // var_dump($post_data);die;
        // echo '1';
        // 验证签名
        $sign =  $_GET['sign'];
        $verify = verify_sign($post_data,$sign,"client_public_key.pem");
        if($verify==0){
            $response = [
                'error' => 50015,
                'msg'   =>  '签名错误'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }elseif($verify=='-1'){
            $response = [
                'error' => 50016,
                'msg'   =>  '内部错误'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        // var_dump($verify);die;
        // 解密
        $dec_data = Asym_private_decrypt($post_data);
        // echo "<pre>";print_r($dec_data);echo "</pre>";
        $username = $dec_data->username;
        $pwd = $dec_data->pwd;
        $qpwd = $dec_data->qpwd;
        $email = $dec_data->email;
        $tel = $dec_data->tel;
        $user_Info = UserModel::where(['email'=>$email])->first();
        if($user_Info){
            $response = [
                'error' => 50011,
                'msg'   =>  '该邮箱已被注册'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        if($pwd != $qpwd){
            $response=[
                'error' => 50012,
                'msg'   => '两次输入的密码不一致'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $password = md5($pwd);
        $data = [
            'username'  =>  $username,
            'password'  =>  $password,
            'email'     =>  $email,
            'tel'       =>  $tel,
            'add_time'  =>  time()
        ];
        $id = UserModel::insertGetId($data);
        if($id){
            $response=[
                'error' => 0,
                'msg'   => 'ok'
            ];
        }else{
            $response=[
                'error' => 50013,
                'msg'   => '注册失败'
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
    /**
     * 登录
     */
    public function login(Request $request){
        // 接收数据
        $post_data = json_decode(file_get_contents("php://input"));
        // 验证签名
        $sign =  $_GET['sign'];
        $verify = verify_sign($post_data,$sign,"client_public_key.pem");
        if($verify==0){
            $response = [
                'error' => 50015,
                'msg'   =>  '签名错误'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }elseif($verify=='-1'){
            $response = [
                'error' => 50016,
                'msg'   =>  '内部错误'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        // 解密
        $dec_data = Asym_private_decrypt($post_data);
        $email = $dec_data->email;
        $password = $dec_data->password;
        $user_Info = UserModel::where(['email'=>$email])->first();
        if($user_Info){
            if(md5($password)==$user_Info['password']){
                $key="login_token:uid".$user_Info['id'];
                $token = getLoginToken($user_Info['id']);
                Cache::put($key,$token,604800);
                // echo Cache::get($key);echo "<hr>";
                // Redis::set($key,$token);
                // echo Redis::get($key);
                $response = [
                    'error' => 0,
                    'msg'   =>  'ok',
                    'token' =>  $token
                ];
            }else{
                $response = [
                    'error' => 50010,
                    'msg'   =>  '密码错误',
                ];
            }
        }else{
            $response = [
                'error' => 50014,
                'msg'   =>  '该邮箱还未注册',
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
        // // echo "<pre>";print_r($request->input());echo "</pre>";
        // // $email = $request->input('email');
        // // // echo Crypt::encrypt('lumen');
        // // $password = $request->input('password');
        // // echo $password;echo "<br>";
        // var_dump($_GET['public_key']);
        // $post_json = file_get_contents("php://input");
        // var_dump($post_json);
        // $post = json_decode(file_get_contents("php://input"),true);
        // // var_dump($post);
        // $email = $post['email'];
        // $password = $post['password'];
        // echo $password;die;
        // $public_key = $post['public_key'];
        // // echo $public_key;
        // // echo decrypt($password);echo "<br>";
        // // echo Crypt::encrypt("aa");echo "<br>";
        // $pwd = Crypt::decrypt($password);echo "<br>";
        // // echo decrypt($password);
        // // $key="longbinpwd";
        // // $service    =   new UseRedisService();
        // // $result     =   $service->get($key);
        // // echo $result;
        // $user = UserModel::where(['email'=>$email])->first();
        // // echo str_random(32);die;
        // // echo "<pre>";print_r($user);echo "</pre>";
        // $user_pwd = $user->password;
        // if($pwd == $user_pwd){
        //     $response = [
        //         'error' => 0,
        //         'msg'   =>"ok"
        //     ];
        // }else{
        //     $response = [
        //         'error' => 50010,
        //         'msg'   =>"密码错误"
        //     ];
        // }
        // die(json_encode($response,JSON_UNESCAPED_UNICODE));
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



    public function ajaxreg(Request $request){
        $post_data = file_get_contents("php://input");
        $account = $request->input('account');
        $password = $request->input('password');
        $email = $request->input('email');
        // // var_dump($post);
        // $json_post = json_decode($post_data);
        // var_dump($json_post);
        // $account = $json_post['account'];
        // $password = $json_post['password'];
        // $email = $json_post['email'];
        $user_Info = AjaxUserModel::where(['email'=>$email])->first();
        if($user_Info){
            $response = [
                'error' => 50011,
                'msg'   =>  '该邮箱已被注册'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        $data = [
            'account'  =>  $account,
            'password'  =>  $password,
            'email'     =>  $email,
            'add_time'  =>  time()
        ];
        $id = AjaxUserModel::insertGetId($data);
        if($id){
            $response=[
                'error' => 0,
                'msg'   => 'ok'
            ];
        }else{
            $response=[
                'error' => 50013,
                'msg'   => '注册失败'
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
        // return 1;
    }
    public function ajaxlogin(Request $request){
        $email = $request->input('account');
        $password = $request->input('password');
        $user_Info = AjaxUserModel::where(['email'=>$email])->first();
        // var_dump($user_Info['password']);
        // var_dump($password);
        if($user_Info){
            if($password==$user_Info['password']){
                $key="login_token:uid".$user_Info['id'];
                $token = getLoginToken($user_Info['id']);
                Cache::put($key,$token,604800);
                // echo Cache::get($key);echo "<hr>";
                // Redis::set($key,$token);
                // echo Redis::get($key);
                $response = [
                    'error' => 0,
                    'msg'   =>  'ok',
                    'uid'   =>  $user_Info['id'],
                    'token' =>  $token
                ];
            }else{
                $response = [
                    'error' => 50010,
                    'msg'   =>  '密码错误',
                ];
            }
        }else{
            $response = [
                'error' => 50014,
                'msg'   =>  '该邮箱还未注册',
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
}
