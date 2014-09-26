<?php echo $header; ?>
<div id="content" class="square" style="background:transparent;border:0px;">
  <div>
	<div class="checkout-content" style="display:block;">
	<span>正在支付...</span>
	</div>
  </div>
</div>

<script type="text/javascript"><!--

$(document).ready(
	function(){
		WeixinJSBridge.invoke('getBrandWCPayRequest', {
			"appId" : "<?php echo $appId; ?>",
			"signType" : "<?php echo $signType; ?>",
			"package" : "<?php echo $package; ?>",
			"timeStamp" : "<?php echo $timeStamp; ?>",
			"nonceStr" : "<?php echo $nonceStr; ?>",
			"paySign" : "<?php echo $paySign; ?>"
		},function(res){
			location.href = "<?php echo $pay_result; ?>"; 
		});
});
//--></script>
</body></html>