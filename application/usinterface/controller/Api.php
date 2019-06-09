<?php
namespace app\usinterface\controller;
use think\Controller;

class Api extends controller
{
    public function index()
    {
        return "my Api";
    }
	
	public function message()
	{
		header('Access-Control-Allow-Origin:*');
		header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
		header('Access-Control-Allow-Methods: GET, PUT, POST');
		
        $user_key = request()->param('key');
        $data = null;
        //判断是否有这个key存在
        $input = $_POST;
        
        $code_list = array(["code"=>0,"msg"=>"提交成功！"],["code"=>1,"msg"=>"提交失败，请检查输入内容！"],["code"=>2,"msg"=>"提交失败，请检查接口！"]);
       
        if(empty($input) || empty($user_key))
        {
            return json($code_list[2]);
        }
        //判断电话格式
		
		if(@!ereg("^[1][3-8][0-9]{9}$",$input['phone'])){
           
            return json($code_list[1]);
        }
		
        //判断传入的数据是否有下列字段
        $ary = array('name','phone','qq','url','content');

        for( $i = 0;$i<count($ary);$i++)
        {
            if(!array_key_exists($ary[$i],$input))
            {
                return json($code_list[2]);
            }
        }
        $data['customer_name'] = $input['name'];
        $data['customer_phone'] = $input['phone'];
        $data['customer_wx'] = $input['qq'];
        $data['customer_url'] = $input['url'];
        $data['customer_ip'] = $this->getIp();
        $data['customer_content'] = $input['content'];
        $data['sub_time'] = time();
        $data['customer_state'] = 0;
        //判断所属用户
        $is_user = db('db_admin_user')->where('user_out_id','eq',$user_key)->field('id')->select();
        if(count($is_user) != 1)
        {
            $data['user_id'] = 0;
        }
        else{
            $data['user_id'] = $is_user[0]['id'];
        }
        
        $save_msg = db('db_customer')->insert($data);
        if(!$save_msg)
        {
            return json($code_list[2]);
        }
        
        return json($code_list[0]);
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
