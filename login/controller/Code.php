<?php

namespace app\login\controller;

use think\Controller;
use think\Request;

class Code extends Controller
{

    public function index(Request $request)
    {
        //获取code
        $code = $request->get('code');
        //发送code
        $appid = "wx2de5c1c840e3f9c4";
        $secret = "6787854c1504ffdd04f80ba77c5341b3";
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_exec($ch);
//        接收openid和session_key
        $res = curl_multi_getcontent($ch);
        curl_close($ch);
        return $res;
    }
}
