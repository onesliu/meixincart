<?php
	include_once '../config.php';
	include_once(DIR_APPLICATION."controller/weixin/lib/WxPayHelper.php");
	require_once(DIR_SYSTEM . 'library/session.php');
	
	$session = new Session();
	
	$code = $session->data['oauth_code'];
	$state = $session->data['oauth_state'];
	
	$addrParam['appId'] = 'wx6e583cf65adf0f29';
	$addrParam['timeStamp'] = time();
	$addrParam['nonceStr'] = '12345678';
	$addrParam['token'] = $session->data['oauth_access_token'];
	$addrParam['url'] = "http://qy.gz.1251102575.clb.myqcloud.com/pay/paytest.php?code=$code&state=$state";
	
	$addrHelper = new WxPayHelper(null);
	$addrHelper->setParameter("appid", $addrParam['appId']);
	$addrHelper->setParameter("url", $addrParam['url']);
	$addrHelper->setParameter("timestamp", $addrParam['timeStamp']);
	$addrHelper->setParameter("noncestr", $addrParam['nonceStr']);
	$addrHelper->setParameter("accesstoken", $addrParam['token']);
	
	$sign = $addrHelper->create_addr_sign();
	$addrParam['addrSign'] = $sign['sha1'];
?>
<html>
<head>
	<script type="text/javascript">

	function editaddr() {
		WeixinJSBridge.invoke('editAddress',{
			"appId" : "<?php echo $addrParam['appId']; ?>",
			"scope" : "jsapi_address",
			"signType" : "sha1",
			"addrSign" : "<?php echo $addrParam['addrSign']; ?>",
			"timeStamp" : "<?php echo $addrParam['timeStamp']; ?>",
			"nonceStr" : "<?php echo $addrParam['nonceStr']; ?>",
			},function(res){
				if (res != null) {
					alert(res.err_msg);
				}
			});
	}
	
	</script>
</head>
<body>
	<a onclick="editaddr()">编辑收货地址</a>
	<p><?php print_r($addrParam); ?></p>
	<p><?php echo $_REQUEST['REQUEST_URI'];?></p>
</body>
</html>
