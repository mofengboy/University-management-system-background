<?php

namespace app\wechat\model;

use think\Model;

class Notice extends Model
{
    //向数据库中存储任务通知数据
    function saveNotice($person,$checkTime,$building,$room,$rule){
        $info = Notice::create([
            'person'=>$person,
            'check_time'=>$checkTime,
            'building'=>$building,
            'room'=>$room,
            'rule'=>$rule
        ]);
        if($info != null){
            return 1;
        }else{
            return -2;
        }
    }

    //提取数据库中最近的三条信息
    function acceptNotice(){
        $info = Notice::where('id','>=','0')->limit(3)->select();
        return $info;
    }
}
