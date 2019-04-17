<?php

namespace app\common\controller;

use think\Controller;
use think\Request;

class User extends Controller
{
    //获取code
    public function index(Request $request){
        $code = $request->get('code');
        return json($code);
    }
}
