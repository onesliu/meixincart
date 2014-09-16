<?php
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinPrepayResult extends ControllerWeixinWeixin {
	public function index() {

		$payresult = false;
		
    	$order_info = $this->session->data['order_info'];
   		$this->submit_order($order_info);
   		$payresult = true;
    	
    	$this->data['payresult'] = $payresult;
		$this->data['continue'] = $this->url->link('mobile_store/order');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/weixin/prepay_result.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/weixin/prepay_result.tpl';
		} else {
            $this->template = 'default/template/weixin/prepay_result.tpl';
        }
		
		$this->children = array(
			'mobile_store/footer',
			'mobile_store/header'	
		);

		$this->response->setOutput($this->render());
	}
	
	public function submit_order($order_info) {
		$this->load->model('checkout/order');
		
		//$this->log->write(print_r($this->request->post, true));
		$order_info['shipping_district_id'] = $this->request->post['district-select'];
		$order_info['shipping_time'] = $this->request->post['time-select'];
		$order_info['shipping_firstname'] = $this->request->post['user_name'];
		$order_info['shipping_telephone'] = $this->request->post['user_telephone'];
		$order_info['shipping_address_1'] = $this->request->post['user_addr'];
		
		$this->model_checkout_order->addOrder($order_info);
		$this->model_checkout_order->confirm($order_info['order_id'], 1);
				
		$this->cart->clear();
	}
}
?>