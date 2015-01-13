<?php
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
		
		$this->data['saveaddr_url'] = $this->url->link('mobile_store/shipping/saveaddr');

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
			$shipping_interval = 6;
		
		$first_shipping_time = $this->config->get('first_shipping_time');
		if ($first_shipping_time == null)
			$first_shipping_time = 11;
			
		$last_shipping_time = $this->config->get('last_shipping_time');
		if ($last_shipping_time == null)
			$last_shipping_time = 19;
		
		$date_now = getdate();
		$start_time = $date_now['hours'] + 2;
		
		$today = date("Y-m-d", time());
		$tomorow = date("Y-m-d", time()+24*60*60);
		
		for($i = $first_shipping_time;$i <= $last_shipping_time; $i+= $shipping_interval) {
			if ($start_time < $i)
				$this->data['shipping_time']["$today $i:00:00"] = "今天 $i:00";
		}
		
		for($i = $first_shipping_time; $i <= $last_shipping_time; $i+= $shipping_interval) {
			$this->data['shipping_time']["$tomorow $i:00:00"] = "明天 $i:00";
		}
		
		$this->data['user_telephone'] = $this->customer->getTelephone(); 
		
		$addrHelper = new PayHelper();
		$addrHelper->add_param("appid", $this->appid);
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$addrParam['url'] = str_replace("&amp;", "&", $url);
		$addrHelper->add_param("url", $addrParam['url']);
		$addrParam['timeStamp'] = time();
		$addrHelper->add_param("timestamp", $addrParam['timeStamp']);
		$addrParam['nonceStr'] = $addrParam['timeStamp'];
		$addrHelper->add_param("noncestr", $addrParam['nonceStr']);
		if (isset($this->session->data['oauth_access_token'])) {
			$addrParam['token'] = $this->session->data['oauth_access_token'];
			$addrHelper->add_param("accesstoken", $addrParam['token']);
		}
		
		$sign = $addrHelper->make_addr_sign();
		$addrParam['addrSign'] = $sign;
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