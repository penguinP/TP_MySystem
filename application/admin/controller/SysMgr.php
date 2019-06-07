<?php
namespace app\admin\controller;
use think\Controller;

class SysMgr	extends Common
{
    public function index()
    {
    	
   
        return $this->fetch();
    }
	
	
	public function usermgr()
    {
    	
   
        return $this->fetch();
    }

    public function getuser()
    {
    	if($this->userid != 0)
		{
			$this->error("无权限！","/admin/");
		}
		$re_data = null;
		
		$user_list = db('db_admin_user')->where('id','neq',0)->field("id,user_name as username,explan,last_login_ip as ip,last_login_time as time,user_out_id as userkey")->select();
		
		
		$re_data['code'] = 0;
		$re_data['msg'] = '';
		
		$re_data['count'] = count($user_list);
		
		$re_data['data'] = $user_list;
		
        return json($re_data);
    }
	
	public function adduser()
	{
		
		return $this->fetch();
	}
	
	public function reguser(){
		
		$form = $_POST;
		$data = null;
		$re_code = array(["code"=>0,"msg"=>"注册成功！"],["code"=>1,"msg"=>"注册失败,用户名已存在!"],["code"=>2,"msg"=>"注册失败,未知原因!"]);
		
		if(!isset($form))
		{
			return json($re_code[2]);
		}
		//判断用户重复
		
		$rep = db('db_admin_user')->where('user_name','eq',$form['username'])->find();
		
		if(isset($rep))
		{
			return json($re_code[1]);
		}
		$data['user_name'] = $form['username'];
		$data['user_pass'] = md5($form['username'].'_'.$form['password']);
		$data['explan'] = $form['remarks'];
		$data['last_login_ip'] = $this->getIp();
		$data['last_login_time'] = time();
		$data['user_out_id'] = md5($form['username']);
		
		$in = db('db_admin_user')->insert($data);
		if(!$in)
		{
			return json($re_code[2]);
		}
		
		return json($re_code[0]);
	}
	
	public function updateuser()
	{	
		$user_id = request()->param('id'); //获取请求的变量
		
		dump($user_id);die();
		return $this->fetch();
	}
	
	public function updateuser1()
	{
		$form = $_POST;
		$data = null;
		$re_code = array(["code"=>0,"msg"=>"更新成功！"],["code"=>1,"msg"=>"更新失败,用户名已存在!"],["code"=>2,"msg"=>"更新失败,未知原因!"]);
		
		return '1';
	}
}
