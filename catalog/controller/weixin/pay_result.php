<?php
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinPayResult extends ControllerWeixinWeixin {
	public function index() {

		$payresult = false;
		
    	$this->load->model('checkout/order');
    	$order_info = $this->session->data['order_info'];
    	/*if ($order_info['order_status_id'] < 3) {
    		//还是未支付状态，发起支付查询
			$this->load->model('weixin/query_order');
    		$qrst = $this->model_weixin_query_order->query($this->access_token, $order_info);
			
			if ($qrst->errcode == 0 && $qrst->errmsg == "ok") {
				//支付成功
				$this->submit_order();
				$payresult = true;
			}
			else {
				//支付查询失败
				$this->log->write("orderquery error, errcode:".$result->errcode." errmsg:".$result->errmsg);
			}
    	}
    	else*/ {
    		$this->submit_order();
    		$payresult = true;
    	}
    	
    	$this->data['payresult'] = $payresult;
		$this->data['continue'] = $this->url->link('mobile_store/order');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/weixin/pay_result.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/weixin/pay_result.tpl';
		} else {
            $this->template = 'default/template/weixin/pay_result.tpl';
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
		
		$this->model_checkout_order->addOrder($this->session->data['order_info']);
		$this->model_checkout_order->confirm($this->session->data['order_id'], 1);
		
		$this->cart->clear();
	}
}
?>