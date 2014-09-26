<?php echo $header; ?>
<script type="text/javascript"><!--

$(document).ready(function(){
	WeixinJSBridge.invoke('getBrandWCPayRequest', {
		"appId" : "<?php echo $appId; ?>",
		"signType" : "<?php echo $signType; ?>",
		"package" : "<?php echo $package; ?>",
		"timeStamp" : "<?php echo $timeStamp; ?>",
		"nonceStr" : "<?php echo $nonceStr; ?>",
		"paySign" : "<?php echo $paySign; ?>"
		},function(res){
			location.href = "<?php echo $pay_result; ?>"; 
		}
	);
}
//--></script>
<?php echo $footer; ?>