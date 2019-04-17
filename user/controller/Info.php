<?php

namespace app\user\controller;

use app\common\model\User;
use think\App;
use think\Controller;
use think\Request;

class Info extends Controller
{
    //接受token 获取用户基本信息
    function basic(Request $request){
        $token = $request->post('token');

        if(($token == NULL)||($token == "参数不合法！")){
            return json('参数不合法！');
        }else {
            $user = User::where('open_id', $token)->find();
            $user_basic = [
                'nick_name' => $user->nick_name,
                'real_name' => $user->real_name,
                'phone_number' => $user->phone_number,
                'gender' => $user->gender,
                'authority' => $user->authority
            ];
            return json($user_basic);
        }
    }
}
