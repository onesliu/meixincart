<?php

/*微信订单编号格式：
 * 平台：0-9 公众号支付(1)、小额刷卡(2)
 * 支付类型：0-9 JSAPI(0)、NATIVE(1)、APP支付(2)
 * 业务类型：0-9 菜鸽子(0)、快消品、等等
 * 保留：00
 * 时间：20040801150101 当前时间，年月日时分秒
*/
function new_wx_orderid($platform = 1, $paytype = 0, $btype = 0, $reserve = 0) {
	return sprintf("%d%d%d%02d%s", $platform, $paytype, $btype, $reserve, strftime('%Y%m%d%H%M%S'));
}
?>