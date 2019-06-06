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
  
        $input = $_POST;
        $code_list = array(["code"=>0,"msg"=>"提交成功！"],["code"=>1,"msg"=>"提交失败，请检查输入内容！"]);
        $re_code = null;

        
  
  
        return json_encode($re_code);
	}
}
