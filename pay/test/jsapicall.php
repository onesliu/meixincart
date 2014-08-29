<?php
include_once("WxPayHelper.php");


$commonUtil = new CommonUtil();
$wxPayHelper = new WxPayHelper();


$wxPayHelper->setParameter("bank_type", "WX");
$wxPayHelper->setParameter("body", "test");
$wxPayHelper->setParameter("partner", "1220519101");
$wxPayHelper->setParameter("out_trade_no", $commonUtil->create_noncestr());
$wxPayHelper->setParameter("total_fee", "1");
$wxPayHelper->setParameter("fee_type", "1");
$wxPayHelper->setParameter("notify_url", "http://qy.gz.1251102575.clb.myqcloud.com/pay/weixin.php");
$wxPayHelper->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);
$wxPayHelper->setParameter("input_charset", "UTF-8");





?>
<html>
<script language="javascript">
function callpay()
{
	WeixinJSBridge.invoke('getBrandWCPayRequest',<?php echo $wxPayHelper->create_biz_package(); ?>,function(res){
	WeixinJSBridge.log(res.err_msg);
	alert(res.err_code+res.err_desc+res.err_msg);
	});
}
</script>
<body>
<button type="button" onclick="callpay()">wx pay test</button>
</body>
</html>
