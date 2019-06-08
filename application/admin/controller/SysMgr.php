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
		
		//时间戳转换
		foreach($user_list as $key=>$value)
		{
			$user_list[$key]['time'] = date('Y-m-d H:i:s',$value['time']);
		}
		
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
		$data['user_out_id'] = md5(time().'_'.$form['username']);//注册时间加初始用户名
		
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
		
		$re_data = db('db_admin_user')->where('id','eq',$user_id)->find();

		$this->assign('id',$user_id);
		$this->assign('username',$re_data['user_name']);
		$this->assign('remarks',$re_data['explan']);
		return $this->fetch();
	}
	
	public function updateuser1()
	{
		$form = $_POST;
		$data = null;
		$re_code = array(["code"=>0,"msg"=>"更新成功！"],["code"=>1,"msg"=>"更新失败,用户名已存在!"],["code"=>2,"msg"=>"更新失败,请输入新数据!"]);
		
		//判断用户重复,除去此条数据
		
		 $rep = db('db_admin_user')->where('id','neq',$form['id'])->where('user_name','eq',$form['username'])->find();
		
		 if(isset($rep))
		 {
		 	return json($re_code[1]);
		 }
		
		$data['user_name'] = $form['username'];
		$data['explan'] = $form['remarks'];
		if($form['password'] != '')
		{
			$data['user_pass'] = $form['password'];
		}
		$update = db('db_admin_user')->where('id','eq',$form['id'])->update($data);

		if(!$update)
		{
			return json($re_code[2]);
		}
		return json($re_code[0]);
	}

	public function deluser(){
		$form = $_POST;
		$re_code = array(["code"=>0,"msg"=>"删除成功！"],["code"=>1,"msg"=>"删除失败,用户不存在!"],["code"=>2,"msg"=>"删除失败,未知错误!"]);
		
		if($form['id'] == 0)
		{
			return json($re_code[2]);
		}
		$del = db('db_admin_user')->where('id','eq',$form['id'])->delete();
		if(!$del)
		{
			return json($re_code[1]);
		}

		return json($re_code[0]);
	}

	public function usermsg(){

		$interface = null;
		if($this->userid==0)
		{
			$interface = "管理员，无留言接口！";
		}else{

			$interface = 'http://'.input('server.HTTP_HOST').'/usinterface/api/message/key/'.session('user')['user_out_id'];
		}
		$this->assign('username',$this->username);
		$this->assign('interface',$interface);
		return $this->fetch();
	}
}
