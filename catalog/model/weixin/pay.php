<?php
include_once(DIR_APPLICATION."controller/weixin/lib/wxtools.php");

class ModelWeixinPay extends Model {
	
	public function sendUnifiedOrder() {
		$url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
		$res = postToWx($url, $content);
	}
	
	private function makeUnifiedRequest() {
		
	}
}
?>