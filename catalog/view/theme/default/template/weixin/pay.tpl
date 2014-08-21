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

function editaddr() {
	WeixinJSBridge.invoke('editAddress',{
		"appId" : <?php echo $addrParam['appId']; ?>,
		"scope" : "jsapi_address",
		"signType" : "sha1",
		"addrSign" : <?php echo $addrParam['addrSign']; ?>,
		"timeStamp" : <?php echo $addrParam['timeStamp']; ?>,,
		"nonceStr" : <?php echo $addrParam['nonceStr']; ?>,,
		},function(res){
		//若res 中所带的返回值不为空，则表示用户选择该返回值作为收货地
		//址。否则若返回空，则表示用户取消了这一次编辑收货地址。
			if (res != null) {
				$('#user_name').val(res.userName);
				$('#user_telephone').val(res.telNumber);
				$('#user_addr').val(res.proviceFirstStageName + 
									res.addressCitySecondStageName +
									res.addressCountiesThirdStageName + " " +
									res.addressDetailInfo);
				$('#addr_none').css("display", "none");
				$('#addr').css("display", "block");
			}
		});
}
//--></script>