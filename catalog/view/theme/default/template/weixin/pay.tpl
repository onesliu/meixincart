  <div>
    <div class="center"><a onclick="if (weixin_pay()) {$('#weixin_payment').submit();}" class="button_11 orange orange_borderbottom radius4">微信支付</a></div>
  </div>
  
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