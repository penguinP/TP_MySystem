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
		$admin_id = session('user')['id'];
		$where = null;
		$re_data = null;
		
		if($admin_id != 0)
		{
			$where="admin_id eq ".$admin_id;
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
}
