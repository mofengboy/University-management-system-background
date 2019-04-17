<?php

namespace app\wechat\controller;

use app\common\model\User;
use think\Controller;
use think\Request;

class Person extends Controller
{
    //更换手机
    function phone(Request $request){
        //接受数据
        $token = $request->post('token');
        $oldPhone = $request->post('oldPhone');
        $newPhone = $request->post('newPhone');
        //验证信息
        if(($token == null)||($oldPhone == null)||($newPhone == null)){
            return -1;
        }
        //实例化Model
        $user = new User;
        //读取数据库，更换手机
        $result = $user->change_phone($token,$oldPhone,$newPhone);
        return json($result);
    }
    //申请权限
    function authority(Request $request){
        //接受数据
        $token = $request->post('token');
        $auth = $request->post('auth');
        //实例化Model
        $user = new User;
        //向数据库中提交权限申请
        $result = $user->applyAuth($token,$auth);
        return json($result);
    }
    //意见反馈
    function feedback(Request $request){
        //接受数据
        $token = $request->post('token');
        $content = $request->post('content');
        //验证信息
        if(($token ==null)||($content == null)){
            return -1;
        }
        //实例化Model
        $user = new User;
        //保存意见于数据库中
        $result = $user->submitFeedback($token,$content);
        return json($result);
    }
}
