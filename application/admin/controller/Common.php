<?php
namespace app\admin\controller;
use think\Controller;

class Common extends controller
{
	public $userid=null;
	public $username=null;
     public function __construct()
    {
		parent::__construct();
		
		if(!session('user'))
		{
			$this->redirect('login/login/index',302);
		}

		$user=session('user');
        $this->userid=$user['id'];
        $this->username=$user['user_name'];
	}
	
	public function getIp() {
		//strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$ip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
		return $res;
	}
	
}
