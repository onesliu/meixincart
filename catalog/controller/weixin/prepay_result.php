<?php
class ControllerWeixinPrepayResult extends ControllerWeixinPayResult {
	public function index() {

		$payresult = false;
		
		if (isset($this->session->data['order_info'])) {
	    	$order_info = $this->session->data['order_info'];
	   		$this->submit_order($order_info);
	   		$payresult = true;
		}
		else {
			$this->redirect($this->url->link('mobile_store/home'));
		}
    	
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
	
}
?>