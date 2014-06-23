<?php
header("Content-Type:text/html;charset=UTF-8");
require_once 'util.php';
$appKey = '21798867';
$appSecret = 'f319e4c8f72f0776ba206e904074a816';
$sessionkey= '6101e188b5aeb025010269ab80119a9098c5b72c2d873332025928648';
//参数数组
$paramArr = array(
     'app_key' => $appKey,
     'session_key' => $sessionkey,
     'method' => 'taobao.user.seller.get',
     'format' => 'json',
     'v' => '2.0',
     'sign_method'=>'md5',
     'timestamp' => date('Y-m-d H:i:s'),
     'fields' => 'nick,type,user_id',
    // 'nick' => 'sandbox_c_1'
);
//生成签名
$sign = createSign($paramArr);
//组织参数
$strParam = createStrParam($paramArr);
$strParam .= 'sign='.$sign;
//访问服务
$url = 'http://gw.api.taobao.com/router/rest?'.$strParam;
$result = file_get_contents($url);
$result = json_decode($result);
echo "json的结构为:";
print_r($result);
echo "<br>";
echo "用户名称为:".$result->user_get_response->user->nick;
echo "<br>";
echo "买家信用等级为:".$result->user_get_response->user->buyer_credit->level;
?>