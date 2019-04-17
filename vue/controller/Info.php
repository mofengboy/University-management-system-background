<?php

namespace app\vue\controller;

use app\vue\model\Dorm;
use think\Controller;
use think\Request;

class Info extends Controller
{
    function info(Request $request){
        //获取数据
        $timeMonth0 = $request->post('timeMonth0');
        $timeDay0 = $request->post('timeDay0');
        $timeYear0 = $request->post('timeYear0');
        $timeMonth1 = $request->post('timeMonth1');
        $timeDay1 = $request->post('timeDay1');
        $timeYear1 = $request->post('timeYear1');
        //拼接数据
        $time0 = $timeYear0.$timeMonth0.$timeDay0;
        $time1 = $timeYear1.$timeMonth1.$timeDay1;
        //实例化Model
        $score = new Dorm;
        //查询
        $result = $score->acceptDorm($time0,$time1);
        return json($result);
    }
}
