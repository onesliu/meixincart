<?php
$DEBUG_ = true;
//财付通商户号
$partner = "1220519101";
//财付通密钥
$key = "7168f80dd0dcc55e417a5afa0431a255";
//appid
$appid="wx6e583cf65adf0f29";
//paysignkey(非appkey)
$appkey="UdDi6WWTRq";
//appsecret
$appsecret="70a757b4b435e250b9cb26c56f13e3b2";
//支付完成后的回调处理页面,*替换成notify_url.asp所在路径
$notify_url = "http://qy.gz.1251102575.clb.myqcloud.com/index.php?route=weixin/warning";

//日志文件地址
//define("LOG_FILE","C:\AppServ\log.txt");
define("LOG_FILE","");

?>