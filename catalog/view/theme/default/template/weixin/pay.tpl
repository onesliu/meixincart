<script type="text/javascript"><!--

function weixin_pay() {
	WeixinJSBridge.invoke('getBrandWCPayRequest', <?php echo $wxPayHelper->create_biz_package(); ?>, function(res) {
		WeixinJSBridge.log(res.err_msg);
		alert(res.err_code+res.desc);
		if (res.err_msg == "get_brand_wcpay_request:ok") {
			return true;
		}
		return false;
	});
}
//--></script>