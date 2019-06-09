<?php
namespace app\admin\controller;
use think\Controller;

class Index	extends Common
{
    public function index()
    {
        $showorhide =null;
        if($this->userid == 0)
        {
            $showorhide = "show";
        }else{
            $showorhide = "hide";
        }
    	$this->assign('username',$this->username);
        $this->assign('showorhide',$showorhide);
        return $this->fetch();
    }

    public function w_updatepw(){

        $this->assign('username',$this->username);
        $this->assign('userid',$this->userid);
        return $this->fetch();
    }
    public function updatepw()
    {
        $rq = $this->request->param();

        $re_code = array(['code'=>0,'msg'=>'修改成功!'],['code'=>1,'msg'=>'修改失败，请联系管理员!']);
        $new_pw = md5($rq['username'].'_'.$rq['password']);
        $update = db('db_admin_user')->where('id','eq',$rq['id'])->update(['user_pass'=>$new_pw]);
        if(!$update)
        {
            return json($re_code[1]);
        }
        return json($re_code[0]);
    }
}
