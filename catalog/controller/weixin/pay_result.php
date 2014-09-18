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
		$this->load->model('account/district');
		$this->load->model('account/address');
		$this->load->model('account/customer');
		
		//$this->log->write(print_r($this->request->post, true));
		$order_info['shipping_district_id'] = $this->request->post['district-select'];
		$order_info['shipping_time'] = $this->request->post['time-select'];
		$order_info['shipping_firstname'] = $this->request->post['user_name'];
		$order_info['shipping_telephone'] = $this->request->post['user_telephone'];
		$order_info['shipping_address_1'] = $this->request->post['user_addr'];
		
		$addr['firstname'] = $order_info['shipping_firstname'];
		$addr['telephone'] = $order_info['shipping_telephone'];
		$addr['address_1'] = $order_info['shipping_address_1'];
		$addr['district_id'] = $order_info['shipping_district_id'];
		$addr['lastname'] = '';
		$addr['company'] = '';
		$addr['company_id'] = '';
		$addr['tax_id'] = '';
		$addr['address_2'] = '';
		$addr['postcode'] = $this->request->post['user_postcode'];;
		$addr['city'] = $this->request->post['user_city'];;
		$addr['zone_id'] = 0;
		$addr['country_id'] = 44;
		
		$addrid = $this->model_account_address->findAddress($addr);
		if ($addrid == null) {
			 $addrid = $this->model_account_address->addAddress($addr);
		}
		$this->model_account_customer->setLastAddress($this->customer->getId(), $addrid);
		
		$this->model_checkout_order->addOrder($order_info);
		$this->model_checkout_order->confirm($order_info['order_id'], 1);
		
		$this->cart->clear();
	}
}
?>