<?php
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinPrepayResult extends ControllerWeixinWeixin {
	public function index() {

		$payresult = false;
		
    	$this->load->model('checkout/order');
    	$order_info = $this->model_checkout_order->getOrder($this->request->post['out_trade_no']);
    	if ($order_info['order_status_id'] == 0) {
    		$this->submit_order();
    		$payresult = true;
    	}
    	
    	$this->data['payresult'] = $payresult;
		$this->data['continue'] = $this->url->link('mobile_store/order');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/prepay_result.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/prepay_result.tpl';
		} else {
            $this->template = 'default/template/payment/prepay_result.tpl';
        }
		
		$this->children = array(
			'mobile_store/footer',
			'mobile_store/header'	
		);

		$this->response->setOutput($this->render());
	}
	
	public function submit_order() {
		$this->load->model('checkout/order');
		
		//$this->log->write(print_r($this->request->post, true));
		$this->session->data['order_info']['shipping_district_id'] = $this->request->post['district-select'];
		$this->session->data['order_info']['shipping_time'] = $this->request->post['time-select'];
		$this->model_checkout_order->fastupdate($this->session->data['order_id'],
			$this->session->data['order_info']);
		
		$this->model_checkout_order->confirm($this->session->data['order_id'], 1);
		
		$this->cart->clear();
	}
}
?>