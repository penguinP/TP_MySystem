<?php
namespace app\index\controller;
use think\Controller;

class Index	extends Common
{
    public function index()
    {
    	$this->assign('username',session('user')['user_name']);
   
        return $this->fetch();
    }
}
