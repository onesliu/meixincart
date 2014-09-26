<?php echo $header; ?>
<div id="content" class="square" style="background:transparent;border:0px;">
  <div>
	<div class="checkout-content" style="display:block;">
	<span>正在支付...</span>
	</div>
  </div>
</div>

<script type="text/javascript"><!--

/**
 * 当页面加载完毕后执行，使用方法：
 * WeixinApi.ready(function(Api){
 *     // 从这里只用Api即是WeixinApi
 * });
 * @param readyCallback
 */
function wxJsBridgeReady(readyCallback) {
    if (readyCallback && typeof readyCallback == 'function') {
        var Api = this;
        var wxReadyFunc = function () {
            readyCallback(Api);
        };
        if (typeof window.WeixinJSBridge == "undefined"){
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', wxReadyFunc, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', wxReadyFunc);
                document.attachEvent('onWeixinJSBridgeReady', wxReadyFunc);
            }
        }else{
            wxReadyFunc();
        }
    }
}

$(function(){
	wxJsBridgeReady(function(){
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
});
//--></script>
</body></html>