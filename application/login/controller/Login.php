<?php
namespace app\login\controller;
use think\Controller;

class Login	extends controller
{
    public function index()
    {
        return $this->fetch();
    }
	
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
				return json_encode(['type'=>1,'msg'=>'登陆成功']);
			}
		}
		
		return json_encode(['type'=>0,'msg'=>'帐号或密码错误！']);
		
	}
}
