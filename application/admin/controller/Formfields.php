<?php
namespace app\admin\controller;
use think\Controller;

class Formfields	extends Common
{

    public function index()
    {
		   
        return $this->fetch();
    }
	
	public function getform()
	{
		$admin_id = $this->userid;
		$where = null;
		$re_data = null;
		
		if($admin_id != 0)
		{
			$where['user_id'] = $admin_id;
			//判断留言属性
			$where['customer_state']=0;
		}
		$customer = db('db_customer')->where($where)->field("id,customer_name as name,customer_phone as phone,customer_wx as wx,customer_ip as ip,customer_url as url")->select();
		//号码打*
		if($admin_id == 0)
		{
			foreach($customer as $key=>$value)
			{
				for($i=3;$i<7;$i++)
				{
					$customer[$key]['phone'][$i] = "*";
				}
			}
		}
		
	
		$re_data['code'] = 0;
		$re_data['msg'] = '';
		
		$re_data['count'] = count($customer);
		
		$re_data['data'] = $customer;
		
		return json($re_data);
		
	}

	public function delform(){
		$data = $_POST;
		$code_list = array(["code"=>0,"msg"=>"删除成功！"],["code"=>1,"msg"=>"您已删除成功！"],["code"=>2,"msg"=>"删除失败，请联系管理员！"]);
		$re_code = null;
		$user_id=$this->userid;
		$user_name=$this->username;
		if(isset($data['id']))
		{
			if($user_id == 0)
			{
				$db_re = db('db_customer')->where("id eq ".$data['id'])->delete();
				if(!isset($db_re))
				{
					$re_code = $code_list[2];
				}
			}else
			{
				$db_re = db('db_customer')->where("id eq ".$date['id'])->setField("customer_state",0);
				if(!isset($db_re))
				{
					$re_code = $code_list[2];
				}
			}

			$re_code = $code_list[0];
		}else{

			$re_code = $code_list[2];
		}
		return json($re_code);
	}
}
