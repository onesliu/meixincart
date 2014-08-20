<?php
include_once("lib/WxPayHelper.php");

class ControllerWeixinPay extends ControllerWeixinWeixin { 
	public function index() {
		
		if ($this->weixin_init() != true) {
			return; //首次验证或初始化失败
		}
		
		$commonUtil = new CommonUtil();
		$wxPayHelper = new WxPayHelper($this);
		
		$wxPayHelper->setParameter("bank_type", "WX");
		$wxPayHelper->setParameter("body", "购买商品");
		$wxPayHelper->setParameter("partner", $this->partnerid);
		$wxPayHelper->setParameter("out_trade_no", $this->session->data['order_id']);
		$wxPayHelper->setParameter("total_fee", $this->session->data['order_info']['total']);
		$wxPayHelper->setParameter("fee_type", "1");
		$wxPayHelper->setParameter("notify_url", $this->url->link('weixin/pay_notify'));
		$wxPayHelper->setParameter("spbill_create_ip", $this->request->server['REMOTE_ADDR']);
		$wxPayHelper->setParameter("input_charset", "UTF-8");
		
		$this->data['wxPayHelper'] = $wxPayHelper;
		
		// view template
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/weixin/pay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/weixin/pay.tpl';
		} else {
			$this->template = 'default/template/weixin/pay.tpl';
		}
		
		$this->response->setOutput($this->render());
	}
	
}

?>