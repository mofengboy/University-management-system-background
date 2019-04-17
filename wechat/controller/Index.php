<?php

namespace app\wechat\controller;

use app\vue\model\Dorm;
use app\wechat\model\Notice;
use think\Controller;
use think\Request;

class Index extends Controller
{
    //历史纪录查询
    function history(Request $request)
    {
        //接受数据
        $date = $request->post('date');
        $building = $request->post('building');
        $room = $request->post('room');
        //验证信息
        if (($date == null) || ($building == null) || ($room == null)) {
            return -1;
        }
        //实例化Model
        $dorm = new Dorm;
        //查询宿舍信息
        $dormInfo = $dorm->wechatHistory($date, $building, $room);
        return $dormInfo;
    }

    //评分-上传信息部分
    function check(Request $request)
    {
        //接受数据
        $checkDate = $request->post('checkDate');
        $checkTime = $request->post('checkTime');
        $rummager = $request->post('realName');
        $building = $request->post('building');
        $room = $request->post('room');
        $scores = $request->post('scores');
        //验证
//        return json($rummager);
        if (($checkDate == null) || ($checkTime == null) || ($rummager == null) || ($building == null) || ($room == null)
            || ($scores == null)) {
            return -1;
        }
        //实例化Model
        $info = new Dorm;
        //存储数据
        $result = $info->giveMark($checkDate, $checkTime, $rummager, $building, $room, $scores);
        return json($result);
    }

    //评分-上传图片部分
    function check_img(Request $request)
    {
        //接受图片
        $photoFile = request()->file('photoName');
        $id = $request->post('id');
        //实例化Model
        $info = new Dorm;
        $result = $info->uploadImg($photoFile, $id);
        return json($result);
    }

    //发布任务
    function task(Request $request)
    {
        //接受数据
        $person = $request->post('person');
        $checkTime = $request->post('checkTime');
        $building = $request->post('building');
        $room = $request->post("room");
        $rule = $request->post("rule");
        if (($person == null) || ($checkTime == null) || ($building == null) || ($room == null) || ($rule == null)) {
            return -1;
        }
        //实例化Model
        $info = new Notice;
        $result = $info->saveNotice($person, $checkTime, $building, $room, $rule);
        return json($result);
    }

    //接受通知信息
    function notice()
    {
        $info = new Notice();
        $result = $info->acceptNotice();
        return json($result);
    }
}
