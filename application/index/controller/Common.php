<?php
namespace app\index\controller;
use think\Controller;

class Common extends controller
{
     public function __construct()
    {
		parent::__construct();
		
		if(!session('user'))
		{
			$this->redirect('login/login/index',302);
		}
	}
}
