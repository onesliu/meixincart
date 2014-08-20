<?php
class ControllerPaymentWeixin extends ControllerWeixinWeixin {
	public function index() {
    	$this->submit_order();

    	$this->load->model('checkout/order');
    	$order_info = $this->model_checkout_order->getOrder($this->request->post['out_trade_no']);
    	if ($order_info['order_status_id'] <= 1) {
    		//还是未支付状态，发起支付查询
			$commonUtil = new CommonUtil();
			$wxPayHelper = new WxPayHelper($this);
			
			$this->load->model('pay_result/query_order');
			
			$wxPayHelper->setParameter("bank_type", "WX");
			$wxPayHelper->setParameter("body", "购买商品");
			
			$qrst = $this->model_weixin_query_order->query($this->access_token, $wxPayHelper->create_biz_package());
			
			if ($qrst == false) {
				//支付失败
			}
			else {
				
			}
    	}
    	
		$this->data['continue'] = $this->url->link('mobile_store/order');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pay_result.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/pay_result.tpl';
		} else {
            $this->template = 'default/template/payment/pay_result.tpl';
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