<?php
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinPayResult extends ControllerWeixinWeixin {
	public function index() {

		$payresult = false;
		
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
    		$this->submit_order($order_info);
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