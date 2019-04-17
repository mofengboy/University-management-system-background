<?php

namespace app\login\controller;

use app\common\model\User;
use think\Controller;
use think\Request;

class Isopenid extends Controller
{

        function index(Request $request){
            $code = $request->post('code');
            if($code == NULL)
                return json("NULL");

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

            //发送openid查询是否存在，不存在返回NULL ,存在返回open_id
            function code_openid($open_id){
                $res = User::where('open_id',$open_id)->find();
                if($res == NULL){
                    return json("NULL");
                }else{
                return $res->open_id;
                }
            }


//            处理逻辑
            if($code != NULL){
//            发送code
            $api = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";
//            获取到openid
            $res = json_decode(curl($api));
            $open_id = $res->openid;
            $result = code_openid($open_id);
            return $result;
            }else{
                return json("NULL");
            }
        }
}
