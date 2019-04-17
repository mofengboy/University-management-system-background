<?php

namespace app\vue\controller;

use app\common\model\User;
use think\Controller;

class Authority extends Controller
{
    //授权信息管理
    function Auth(){
        //实例化Model
        $user = new User;
        return json($user->checkAuth());
    }
}
