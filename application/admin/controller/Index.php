<?php
namespace app\admin\controller;
use think\Controller;

class Index	extends Common
{
    public function index()
    {
        $showorhide =null;
        if($this->userid == 0)
        {
            $showorhide = "show";
        }else{
            $showorhide = "hide";
        }
    	$this->assign('username',$this->username);
        $this->assign('showorhide',$showorhide);
        return $this->fetch();
    }
}
