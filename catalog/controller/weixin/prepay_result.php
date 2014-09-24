<?php
include_once(DIR_APPLICATION."controller/weixin/pay_result.php");

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
    	
    	if ($payresult == true) {
    		$this->data['error_msg'] = '下单成功，请等待门店称重计价后发送微信支付消息。';
    	}
    	else {
    		$this->data['error_msg'] = '下单失败，请重试';
    	}
		$this->data['continue'] = $this->url->link('mobile_store/order');
		$this->data['text_continue'] = '马上查看订单';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/weixin/error.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/weixin/error.tpl';
		} else {
            $this->template = 'default/template/weixin/error.tpl';
        }
		
		$this->children = array(
			'mobile_store/footer',
			'mobile_store/header'	
		);

		$this->response->setOutput($this->render());
	}
}
?>