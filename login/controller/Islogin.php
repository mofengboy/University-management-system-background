<?php

namespace app\login\controller;

use app\common\model\User;
use think\Controller;
use think\Request;

class Islogin extends Controller
{
    //本地是否有token
    function index(Request $request){
        $token = $request->post('token');
        if($token == NULL){
            return json('参数不合法！');
        }
        $user = User::where('open_id',$token)->find();
        if($user != NULL){
            return json('true');
        }else{
            return json('false');
        }
    }
}
