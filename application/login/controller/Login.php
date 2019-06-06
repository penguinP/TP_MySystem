<?php
namespace app\login\controller;
use think\Controller;

class Login	extends controller
{
    public function index()
    {
		
		if(session('?user'))
		{
			
			$this->redirect('admin/index/index',302);
		}else{
			
			return $this->fetch();
		}
    }
	//ppeng 2019.6.2 登陆
	public function login()
	{
		$input = $_POST;
		
		//帐号密码判断；
		
		$db_user = db('db_admin_user')->where('user_name',$input['username'])->find();
		
		if($db_user)
		{
			if(md5($input['username'].'_'.$input['password']) == $db_user['user_pass'])
			{
				session('user',$db_user);
				$login_time = time();
				$login_ip = $this->getIp();
				
				$db_save = db('db_admin_user')->update(['id'=>$db_user['id'],'last_login_ip'=>$login_ip,'last_login_time'=>$login_time]);
				if(!isset($db_save))
				{
					return json_encode(['type'=>2,'msg'=>'数据更新错误！']);
				}
				return json_encode(['type'=>0,'msg'=>'登陆成功']);
			}
		}
		
		return json_encode(['type'=>1,'msg'=>'帐号或密码错误！']);
		
	}

	public function quit(){
		session(null);
		$this->redirect('login/login/index',302);
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
