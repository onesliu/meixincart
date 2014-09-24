<?php
include_once(DIR_APPLICATION."controller/weixin/lib/wxtools.php");
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinPay extends ControllerWeixinWeixin { 
	public function index() {
		
		if ($this->weixin_init() != true) {
			return; //首次验证或初始化失败
		}
		
		$wxPayHelper = new PayHelper();
		
		$order_info = $this->session->data['order_info'];
		
		$wxPayHelper->add_param("appid", (string)$this->appid);
		$wxPayHelper->add_param("mch_id", (string)$this->partnerid);
		$wxPayHelper->add_param("nonce_str", (string)time());
		$wxPayHelper->add_param("body", (string)$order_info['comment']);
		$wxPayHelper->add_param("out_trade_no", (string)$order_info['order_id']);
		$wxPayHelper->add_param("total_fee", (int)($order_info['total']*100));
		$wxPayHelper->add_param("notify_url", $this->url->link('weixin/pay_notify'));
		$wxPayHelper->add_param("spbill_create_ip", (string)$this->request->server['REMOTE_ADDR']);
		$wxPayHelper->add_param("trade_type", "JSAPI");
		$wxPayHelper->add_param("openid", $this->customer->getEmail());
		
		$request = $wxPayHelper->make_request($this->partnerkey);
		$url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
		$response = postToWx($url, $request);
		if ($response['rescode'] != 200) {
			$this->log->write("weixin prepay response error, ". $response['rescode']);
			$this->error();
			return;
		}
		
		$resHelper = new PayHelper();
		$res = $resHelper->parse_response($response['content']);
		if (isset($res->return_code) == false || isset($res->return_msg) == false ||
			isset($res->result_code) == false || (string)$res->return_code != 'SUCCESS' ||
			(string)$res->result_code != 'SUCCESS') {
			$this->log->write("prepay response error: \n". $response['content']);
			$this->error();
			return;
		}
		
		if ($resHelper->sign_verify($this->partnerkey) != true) {
			$this->log->write("prepay response sign verify error: \n". $response['content']);
			$this->error();
			return;
		}
		
		$jsHelper = new PayHelper();
		$jsHelper->add_param('appId', $resHelper->get('appid'));
		$jsHelper->add_param('signType', 'MD5');
		$jsHelper->add_param('package', "prepay_id=".$resHelper->get('prepay_id'));
		$jsHelper->add_param('timeStamp', time());
		$jsHelper->add_param('nonceStr', $jsHelper->get('timeStamp'));
		$this->data['appId'] = $jsHelper->get('appId');
		$this->data['signType'] = $jsHelper->get('signType');
		$this->data['package'] = $jsHelper->get('package');
		$this->data['timeStamp'] = $jsHelper->get('timeStamp');
		$this->data['nonceStr'] = $jsHelper->get('nonceStr');
		$this->data['paySign'] = $jsHelper->sign_make($this->partnerkey);
		
		// view template
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/weixin/pay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/weixin/pay.tpl';
		} else {
			$this->template = 'default/template/weixin/pay.tpl';
		}
		
		$this->render();
	}
	
	private function error() {
		$this->session->data['error_msg'] = "微信服务器出错";
		$this->session->data['url_continue'] = $this->url->link('mobile_store/cart');
		$this->session->data['text_continue'] = '返回购物车';
		$this->redirect($this->url->link('weixin/error'));
	}
}

?>