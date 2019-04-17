<?php

namespace app\vue\controller;

use app\vue\model\VueUser;
use think\Controller;
use think\Request;

class Login extends Controller
{
    //首页
    function index(){
        return json("VUE管理员页面");
    }
    //登陆部分
    function login(Request $request)
    {
        //接收数据
        $username = $request->post('username');
        $password = $request->post('password');
        //检测是否输入账号和密码
        if(($username ==NULL)||($password == NULL)){
            return -1;
        }
        // 实例化Model
        $user = new VueUser;
        // 查询数据库
        $info = $user->selectDatabase($username,$password);
        // 制作token
        $token = $user->makeToken($info);
        // 存储Token并构建数组，返回token值和成功值1
        $result = [
            'token'=>$user->saveToken($token,$username),
            'isSuccess'=>1
        ];
        //返回token值
        return json($result);
    }
    //验证token部分
    function checkToken(Request $request){
        //接受token
        $token = $request->post('token');
        // 实例化Model
        $user = new VueUser;
        //判断数据库中是否有token
        $isToken = $user->databaseToken($token);
        return $isToken;
    }
}
