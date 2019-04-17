<?php

namespace app\vue\model;

use think\Model;

class VueUser extends Model
{
    /*
     * 查询数据库
     * 若未查询到返回错误值-2
     * */
    function selectDatabase($username,$password)
    {
        $user = VueUser::where(["username"=>$username,"password"=>$password])->find();
        if ($user != NULL) {
        $userInfo = [
            'username' => $user['username'],
            'password' => $user['password'],
        ];
        return $userInfo;
        }else{
            return -2;
        }
    }
    /*
     * 制作Token
     * 标准方法太麻烦，所以采用拼接用户名密码和时间戳用md5加密
     * 见谅！
     * */
    function makeToken($userInfo){
        $loginTime = time();
        $raw = $userInfo['username'].$userInfo['password'].$loginTime;
        $token = md5($raw);
        return $token;
    }
    /*
     * 将token存入数据库,并返回存入的token
     * */
    function saveToken($token,$username){
        $vueUser= VueUser::where('username',$username)->find();
        $vueUser->token = $token;
        $vueUser->save();
        //返回存入的token
        return $vueUser->token;
    }
    /*
     * 向数据库中查询token
     * 存在返回0,不存在-1
     * */
    function databaseToken($token){
        $checkInfo = VueUser::where('token',$token)->find();
        if($checkInfo == Null){
            return -1;
        }else{
            return 0;
        }
    }
}
