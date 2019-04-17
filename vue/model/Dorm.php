<?php

namespace app\vue\model;

use think\db\exception\DataNotFoundException;
use think\Model;
use \think\File;

class Dorm extends Model
{
    //VUE端获取宿舍评分信息
    function acceptDorm($time0, $time1)
    {
        $info = Dorm::where('check_date', '>=', $time0)
            ->where('check_date', '<=', $time1)
            ->select();
        return $info;
    }

    //微信小程序端获取宿舍评分信息
    function wechatHistory($date, $building, $room)
    {
        $user = Dorm::where(['check_date' => $date, 'building' => $building, 'room' => $room])->find();
        return $user;
        $info = [
            'checkDate' => $user->check_date,
            'checkTime' => $user->check_time,
            'scores' => $user->scores,
            'photoUrl' => $user->photo,
            'person' => $user->examinator
        ];

    }

    //评分-数据部分
    function giveMark($checkDate, $checkTime, $rummager, $building, $room, $scores)
    {
        //向数据库中存入数据
        $info = Dorm::create([
            'check_date' => $checkDate,
            'check_time' => $checkTime,
            'rummager' => $rummager,
            'building' => $building,
            'room' => $room,
            'scores' => $scores,
        ]);
        $id = $info->id;
        if ($info != null) {
            $result = [
                'status' => 1,
                'id' => $id
            ];
            return $result;
        } else {
            return -3;
        }
    }

    //评分-上传图片部分
    function uploadImg($photoFile, $id)
    {
        //以时间戳为文件命名
        $filename = time();
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/img/' . $filename;
        $result = $photoFile->move('../public//uploads/img');
        if ($result) {
//               将图片路径存入数据库
            $info = Dorm::where('id', $id)->find();
            $info->photo = 'https://college.netlab.sunan.me' . '/uploads/img/' . $result->getSaveName();
            $info->save();
            return 0;
        } else {
            return -2;
        }

    }
}
