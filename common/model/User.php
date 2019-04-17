<?php

namespace app\common\model;

use think\Model;

class User extends Model
{
    //查询权限信息
    function checkAuth(){
        $auth = User::select();
        return $auth;
    }
    //申请权限
    function applyAuth($token,$auth){
        $user = User::where('open_id',$token)->find();
        $user->change_authority = $auth;
        $user->save();
        return 0;
    }
    //更换手机
    function change_phone($token,$oldPhone,$newPhone){
        $user = User::where(['open_id'=>$token,'phone_number'=>$oldPhone])->find();
        if($user != null){
            $user->phone_number = $newPhone;
            $user->save();
            return 0;
        }else{
            return -2;
        }
    }
    //意见反馈
    function submitFeedback($token,$content){
        $user = User::where('open_id',$token)->find();
        $user->feedback = $content;
        $user->save();
        return 0;
    }
}
