<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        $wellcome = "This is backstage by Mofeng";
        return json($wellcome);
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
