<?php

namespace app\login\controller;

use app\common\model\User;
use think\Controller;
use think\Request;

class Index extends Controller
{
    function open_id(Request $request){
        $token = $request->post('token');

        function query_openid($token){
          $res = User::where('open_id',$token)->find();
          if($res!= NULL){
              return json("true");
          }else{
              return json("false");
          }
        };

        //处理逻辑
        $result = query_openid($token);
        return $result;
    }
}
