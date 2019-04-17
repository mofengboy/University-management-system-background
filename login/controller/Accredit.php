<?php

namespace app\login\controller;

use app\common\model\User;
use think\Controller;
use think\Request;

class Accredit extends Controller
{
    //添加授权用户信息
    function index(Request $request){
//        数据接受
        $real_name = $request->post('real_name');
        $phone_number= $request->post('phone_number');
        $department = $request->post('department');
        $code = $request->post('code');
        $encryptedData = $request->post('encryptedData');
        $iv = $request->post('iv');
        $rawData = $request->post('rawData');
        $signature = $request->post('signature');
        $authority = 0; //默认权限为0

        //   app信息
        $appid = config('appid');
        $secret = config('app_secret');

        //curl函数
        function curl($api){
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$api);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_exec($ch);
//        接收openid和session_key
            $res = curl_multi_getcontent($ch);
            curl_close($ch);
            return $res;
        }

//        数据解密&验证
        function decode($sessionKey,$encryptedData,$iv,$rawData){
            $aesKey = base64_decode($sessionKey);
            $aesIV = base64_decode($iv);
            $aesCipher = base64_decode($encryptedData);
            $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
            if($rawData = $result){
                return $result;
            }else{
                return('数据已被更改！');
            }

        }

//        向数据库添加用户信息
        function to_database($real_name,$phone_number,$department,$nick_name,
                             $openID,$gender,$country,$province,$city,$language,$avatarUrl,$authority){
            $user = User::create([
                'open_id'=>$openID,
                'real_name'=>$real_name,
                'phone_number'=>$phone_number,
                'department'=>$department,
                'nick_name'=>$nick_name,
                'gender'=>$gender,
                'country'=>$country,
                'province'=>$province,
                'city'=>$city,
                'language'=>$language,
                'avatarUrl'=>$avatarUrl,
                'authority'=>$authority
            ]);
            return $user->open_id;
        }

//            检测是否已经存在open_id

        function check_user_openid($open_id){
            $res = User::where('open_id',$open_id)->find();
            if($res!=NULL){
                return json("exist");
            }
        }
        //处理逻辑
        if(($code != NULL)&&($encryptedData!=NULL)&&($rawData != NULL)&&($real_name != NULL)&&($phone_number!=NULL)){
//            发送code
            $api = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";
//            获取到openid和session_key
            $res = json_decode(curl($api));
            $sessionKey = $res->session_key;
            $openID = $res->openid;

//            检测是否已经存在open_id
            check_user_openid($openID);
//            解密后的数据
            $resData = json_decode(decode($sessionKey,$encryptedData,$iv,$rawData));

//            存入数据库，添加新用户
            $token = to_database($real_name,$phone_number,$department,$resData->nickName,
                $openID,$resData->gender,$resData->country,$resData->province,
                $resData->city,$resData->language,$resData->avatarUrl,$authority);

//            制作token
            if($token != NULL){
                return json($token);
            }else{
                return false;
            }
        }else{
            return json('参数不合法！');
        }
    }
}
