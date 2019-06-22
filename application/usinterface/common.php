<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function getIp() {
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

function getKeyword($i_url){

    if($i_url=="")return null;
    $url = urldecode(strtolower($i_url));

    $i_search=array(//各对应的搜索引擎
        "手机百度"  => ["m.baidu.com","word"],
        "手机搜狗"  => ["wap.sogou.com","keyword"],
        "手机360"   => ["m.so.com","q"],
        "神马"      => ["m.sm.cn","q"],
        "百度"      => ["www.baidu.com","word"],
        "搜狗"      => ["www.sogou.com","query"],
        "360"       => ["www.so.com","q"],
    );

    $hostname = "";//域名
    $search = "";
    $ar_search = null; //url参数数组
    $re_value = null;//返回值["search"=>"搜索引擎","keyword"=>"关键词"]
    $cut1 = substr($url,strpos($url,"://")+3);
    $hostname = substr($cut1,0,strpos($cut1,"/"));

    $search = substr($url,strpos($url,"?")+1);
    //化为数组 获取参数
    $ar_tem = explode("&",$search);
    foreach( $ar_tem as $value)
    {
        $pos = strpos($value,"=");
        if($pos !== false)
        {
            $ar_search[substr($value,0,$pos)] = substr($value,$pos+1);
        }
    }

    //判断搜索引擎，获取关键词
    foreach($i_search as $key => $val)
    {
        
        if(strpos($hostname,$val[0]) !== false)
        {
            $re_value["search"] = $key;
            $re_value["keyword"] = $ar_search[$val[1]];
            break;
        }
    }
    return $re_value;
}