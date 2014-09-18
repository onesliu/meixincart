<?php
include_once(DIR_APPLICATION."controller/weixin/lib/WxPayHelper.php");
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinShipping extends ControllerWeixinWeixin { 
	public function index() {
		
		if ($this->weixin_init() != true) {
			return; //首次验证或初始化失败
		}
		
		$this->load->model('account/address');
		$this->load->model('account/district');

		if (isset($this->session->data['payment_address_id'])) {
			$this->data['address_id'] = $this->session->data['payment_address_id'];
		} else {
			$this->data['address_id'] = $this->customer->getAddressId();
		}

		$address = $this->model_account_address->getAddress($this->data['address_id']);
		if ($address != false) {
			$this->data['address'] = $address;
		}

		// shipping values
		$this->data['text_shipping_time'] = $this->language->get('text_shipping_time');
		$this->data['text_shipping_district'] = $this->language->get('text_shipping_district');
		$this->data['shipping_districts'] = $this->model_account_district->getAddresses();
		if (!isset($this->data['shipping_districts'])) {
			if (count($this->data['shipping_districts']) == 1 &&
				$this->data['shipping_district_id'] == 0) {
					$this->data['shipping_district_id'] = $this->data['shipping_districts']['id'];
				}
		}
		
		// shipping time
		$shipping_interval = $this->config->get('shipping_interval');
		if ($shipping_interval == null)
			$shipping_interval = 1;
		
		$first_shipping_time = $this->config->get('first_shipping_time');
		if ($first_shipping_time == null)
			$first_shipping_time = 9;
			
		$last_shipping_time = $this->config->get('last_shipping_time');
		if ($last_shipping_time == null)
			$last_shipping_time = 19;
		
		$date_now = getdate();
		$start_time = $date_now['hours'] + 2;
		
		$today = date("Y-m-d", time());
		$tomorow = date("Y-m-d", time()+24*60*60);
		
		if ($start_time > $first_shipping_time) {
			$i = $start_time;
			//$this->data['shipping_time'] = array(0 => '立即配送');
		}
		else {
			$i = $first_shipping_time;
		}

		for(;$i <= $last_shipping_time; $i++) {
			$this->data['shipping_time']["$today $i:00:00"] = "$i:00";
		}
		
		for($i = $first_shipping_time; $i <= $last_shipping_time; $i++) {
			$this->data['shipping_time']["$tomorow $i:00:00"] = "明天 $i:00";
		}
		
		$this->data['telephone'] = $this->customer->getTelephone(); 
		$this->data['order_info'] = $this->session->data['order_info'];
		if ($this->data['order_info']['order_type'] == 0)
			$this->data['weixin_payment'] = $this->url->link('weixin/pay_result');
		else
			$this->data['weixin_payment'] = $this->url->link('weixin/prepay_result');
		
		$addrHelper = new WxPayHelper($this);
		$addrHelper->setParameter("appid", $this->appid);
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$addrParam['url'] = str_replace("&amp;", "&", $url);
		$addrHelper->setParameter("url", $addrParam['url']);
		$addrParam['timeStamp'] = time();
		$addrHelper->setParameter("timestamp", $addrParam['timeStamp']);
		$addrParam['nonceStr'] = $addrParam['timeStamp'];
		$addrHelper->setParameter("noncestr", $addrParam['nonceStr']);
		$addrParam['token'] = $this->session->data['oauth_access_token'];
		$addrHelper->setParameter("accesstoken", $addrParam['token']);
		
		$sign = $addrHelper->create_addr_sign();
		$addrParam['addrSign'] = $sign['sha1'];
		$addrParam['signStr'] = $sign['signstr'];
		$addrParam['appId'] = $this->appid;
		
		$this->data['addrParam'] = $addrParam;
		
		//$this->log->write(print_r($addrParam,true));
		
		// view template
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/weixin/shipping.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/weixin/shipping.tpl';
		} else {
			$this->template = 'default/template/weixin/shipping.tpl';
		}
		
		$this->render();
	}
	
}

?>