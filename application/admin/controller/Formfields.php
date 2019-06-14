<?php
namespace app\admin\controller;
use think\Controller;

class Formfields	extends Common
{

    public function index()
    {
		$is_show= true;
		if($this->userid !=0)
		{
			$is_show = false;
		}
		//传用户列表
		$uesr_list = db('db_admin_user')->where('id','neq',0)->field("id,user_name as name")->select();
		
		$this->assign('userlist',$uesr_list);
		$this->assign('is_show',$is_show);
		   
        return $this->fetch();
    }
	
	public function getform()
	{
		$admin_id = $this->userid;
		$where = null;
		$re_data = null;
		$input = $this->request->param();
		
		$limit = $input['limit'];
		$starttime = null;
		$endtime = null;
		$seluserid = null;
		//筛选条件
		if(isset($input['starttime'])&&!empty($input['starttime']))
		{
			$starttime = strtotime($input['starttime']);
		}
		if(isset($input['endtime'])&&!empty($input['endtime']))
		{
			$endtime = strtotime($input['endtime']);
		}
		if(isset($input['seluserid'])&&!empty($input['seluserid']))
		{
			$seluserid = $input['seluserid'];
		}
		//时间条件
		if(!empty($starttime) && !empty($endtime))
		{
			if($endtime<=$starttime){
                    return json(['msg'=>0,'code'=>0,'count'=>0,'data'=>array()]);
			}
			$where.=" and sub_time>=".$starttime." and sub_time<=".$endtime." ";
		}else{
			if(!empty($starttime))
			{
				$where.=" and sub_time>=".$starttime." ";
			}
			if(!empty($endtime))
			{
				$where.=" and sub_time<=".$endtime." ";
			}
		
		}
		//用户选择条件
		if(!empty($seluserid))
		{
			$where.=" and user_id=".$seluserid." ";
		}
		
		if($admin_id != 0)
		{
			
			$where .= " and user_id = ".$admin_id." ";
			//判断留言属性
			$where.=" and customer_state=0 ";
		}
		
		//字符串trim
		if($where)
		{
			$where=trim($where);
            $where=trim($where,'and');
		}
		
		$customer = db('db_customer')
					->where($where)
					->alias('c')
					->field("c.id,c.customer_name as name,c.customer_phone as phone,c.customer_wx as wx,c.customer_content as content,c.customer_ip as ip,c.customer_url as url,c.sub_time as time,c.user_id as userid,c.customer_state as state")
					->order('sub_time desc')
					->paginate($limit);
		//号码打*,数据所属用户名
		$ary_data = $customer->toArray();
		
		if($admin_id == 0)
		{
			$ary_username = db('db_admin_user')->where('id','neq',0)->column('id,user_name');
			foreach($ary_data['data'] as $key=>$value)
			{
				
				if(isset($ary_username[$value['userid']]))
				{	
					$ary_data['data'][$key]['username'] = $ary_username[$value['userid']];
				}else
				{
					$ary_data['data'][$key]['username'] = '未知用户';
				}
				
				for($i=3;$i<7;$i++)
				{
					$ary_data['data'][$key]['phone'][$i] = "*";
				}
			}
		}
	
		//时间戳转换
		foreach($ary_data['data'] as $key=>$value)
		{
			$ary_data['data'][$key]['time'] = date('Y-m-d H:i:s',$value['time']);
		}
	
		$re_data['code'] = 0;
		$re_data['msg'] = '';
		
		$re_data['count'] = $ary_data['total'];
		
		$re_data['data'] = $ary_data['data'];
		
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
				$db_re = db('db_customer')->where("id","eq",$data['id'])->delete();
				if(!isset($db_re))
				{
					$re_code = $code_list[2];
				}
			}else
			{
				$db_re = db('db_customer')->where("id","eq",$data['id'])->setField("customer_state",1);
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
