<?php
include_once(DIR_APPLICATION."controller/weixin/lib/wxtools.php");
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinPay extends ControllerWeixinWeixin { 
	public function index() {
		
		if (!isset($this->session->data['order_info'])) {
			$this->redirect($this->url->link('mobile_store/home'));
		}
		$order_info = $this->session->data['order_info'];
		
		if ($order_info['order_status_id'] != 2) { //不是 待付款 状态不进行支付流程
			$this->session->data['error_msg'] = '订单暂不能支付，可能订单未准备好';
			$this->session->data['url_continue'] = $this->url->link('mobile_store/order');
			$this->session->data['text_continue'] = '马上查看订单';
			$this->redirect($this->url->link('weixin/error'));
			return;
		}
		
		if ($this->weixin_init() != true) {
			$this->error();
			return; //首次验证或初始化失败
		}
		
		$wxPayHelper = new PayHelper();
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
		
		if (isset($order_info['fromdb']) && $order_info['fromdb'] == true)
			$this->submit_order($order_info);
		
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
		
		$this->data['pay_result'] = $this->url->link('weixin/pay_result');
		
		// view template
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/weixin/pay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/weixin/pay.tpl';
		} else {
			$this->template = 'default/template/weixin/pay.tpl';
		}
		
		$this->children = array(
			'mobile_store/header'
		);
		
		$this->response->setOutput($this->render());
	}
	
	public function prepay() {
		if (!isset($this->session->data['order_info'])) {
			$this->redirect($this->url->link('mobile_store/home'));
		}
		$this->submit_order($this->session->data['order_info']);
		$this->session->data['error_msg'] = '下单成功，请等待门店称重计价后发送微信支付消息。';
		$this->session->data['url_continue'] = $this->url->link('mobile_store/order');
		$this->session->data['text_continue'] = '马上查看订单';
		$this->redirect($this->url->link('weixin/error'));
	}
	
	public function submit_order($order_info) {
		$this->load->model('checkout/order');
		$this->load->model('account/district');
		$this->load->model('account/address');
		$this->load->model('account/customer');
		
		//$this->log->write(print_r($this->request->post, true));
		$order_info['shipping_district_id'] = $this->request->post['district-select'];
		$order_info['shipping_time'] = $this->request->post['time-select'];
		$order_info['shipping_firstname'] = $this->request->post['user_name'];
		$order_info['shipping_telephone'] = $this->request->post['user_telephone'];
		$order_info['shipping_address_1'] = $this->request->post['user_addr'];
		
		$addr['firstname'] = $order_info['shipping_firstname'];
		$addr['telephone'] = $order_info['shipping_telephone'];
		$addr['address_1'] = $order_info['shipping_address_1'];
		$addr['district_id'] = $order_info['shipping_district_id'];
		$addr['lastname'] = '';
		$addr['company'] = '';
		$addr['company_id'] = '';
		$addr['tax_id'] = '';
		$addr['address_2'] = '';
		$addr['postcode'] = $this->request->post['user_postcode'];;
		$addr['city'] = $this->request->post['user_city'];;
		$addr['zone_id'] = 0;
		$addr['country_id'] = 44;
		
		$addrid = $this->model_account_address->findAddress($addr);
		if ($addrid == null) {
			 $addrid = $this->model_account_address->addAddress($addr);
		}
		$this->model_account_customer->setLastAddress($this->customer->getId(), $addrid);
		
		$this->model_checkout_order->addOrder($order_info);
		if ($order_info['order_type'] == 0) //固定价订单状态转换至：待付款
			$this->model_checkout_order->confirm($order_info['order_id'], 2);
		else  //变价订单状态转换至：待称重
			$this->model_checkout_order->confirm($order_info['order_id'], 1);
		
		$this->cart->clear();
		unset($this->session->data['order_info']);
	}
}

?>