<?php
include_once(DIR_APPLICATION."controller/weixin/weixin.php");
include_once(DIR_APPLICATION."controller/weixin/lib/wxtools.php");

class ControllerWeixinPayResult extends ControllerWeixinWeixin {
	public function index() {

		if (!isset($this->session->data['order_info'])) {
			$this->redirect($this->url->link('mobile_store/home'));
		}
		
		if ($this->weixin_init() != true) {
			$this->error();
			return; //首次验证或初始化失败
		}
		
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->fastgetOrder($this->session->data['order_info']['order_id']);
    	if ($order_info['order_status_id'] < 3) {
    		
    		//订单还是未支付状态，发起支付查询
			$wxPayHelper = new PayHelper();
			$wxPayHelper->add_param("appid", (string)$this->appid);
			$wxPayHelper->add_param("mch_id", (string)$this->partnerid);
			$wxPayHelper->add_param("nonce_str", (string)time());
			$wxPayHelper->add_param("out_trade_no", (string)$order_info['order_id']);
			
			$request = $wxPayHelper->make_request($this->partnerkey);
			$url = "https://api.mch.weixin.qq.com/pay/orderquery";
			$response = postToWx($url, $request);
			
			if ($response['rescode'] != 200) {
				$this->log->write("weixin order query response error, ". $response['rescode']);
				$this->error();
				return;
			}
			
			$resHelper = new PayHelper();
			$res = $resHelper->parse_response($response['content']);
			if (isset($res->return_code) == false || isset($res->return_msg) == false ||
				isset($res->result_code) == false || (string)$res->return_code != 'SUCCESS' ||
				(string)$res->result_code != 'SUCCESS') {
				$this->log->write("order query response error: \n". $response['content']);
				$this->error();
				return;
			}
			
			if ($resHelper->sign_verify($this->partnerkey) != true) {
				$this->log->write("order query response sign verify error: \n". $response['content']);
				$this->error();
				return;
			}

			//支付结果显示
			$trade_state = array('SUCCESS' => '支付成功',
							'REFUND' => '转入退款',
							'NOTPAY' => '未支付',
							'CLOSED' => '已关闭',
							'REVOKED' => '已撤销',
							'USERPAYING' => '用户支付中',
							'NOPAY' => '未支付(输入密码或确认支付超时)',
							'PAYERROR' => '支付失败(其他原因，如银行返回失败)');
			$this->data['error_msg'] = $trade_state[(string)$res->trade_state];
			
			if ((string)$res->trade_state == 'SUCCESS') {
				if ($order_info['order_status_id'] == 2) {
					$this->model_checkout_order->orderChangeStatus($order_info);
				}
			}

			$this->save_result($order_info, $response['content']);
    	}
    	else {
			$this->data['error_msg'] = '订单已经支付';
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
	
	private function save_result($order_info, $result) {
		$o['weixin_pay_result'] = $result;
		$this->model_checkout_order->fastupdate($order_info['order_id'], $o);
	}
	
}
?>