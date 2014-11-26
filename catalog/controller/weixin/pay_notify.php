<?php
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinPayNotify extends ControllerWeixinWeixin { 
	public function index() {
		
		if ($this->weixin_init() != true) {
			return; //首次验证或初始化失败
		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$xmlstr = file_get_contents("php://input");
		
			$resHelper = new PayHelper();
			$res = $resHelper->parse_response($xmlstr);
			if (isset($res->return_code) == false || isset($res->return_msg) == false ||
				(string)$res->return_code != 'SUCCESS') {
				$this->log->write("weixin notify paied fail: \n". $xmlstr);
				$this->success(); //返回通知正常接收
				return;
			}
			
			if ($resHelper->sign_verify($this->partnerkey) != true) {
				$this->log->write("weixin notify sign verify error: \n". $xmlstr);
				$this->error(); //返回通知校验错误
				return;
			}
			
			if (isset($res->result_code) == false || (string)$res->result_code != 'SUCCESS') {
				$this->success(); //返回通知正常接收
				return;
			}
			
			$this->paied_success($res->out_trade_no, $xmlstr); //更新数据库订单支付成功
			$this->success(); //返回通知正常接收
		}
	}
	
	public function error() {
		$xml = new PayHelper();
		$xml->add_param('return_code', 'FAIL');
		$xml->add_param('return_msg', 'sign verify error');
		$this->response->setOutput($xml->make_param_xml());
	}

	private function success() {
		$xml = new PayHelper();
		$xml->add_param('return_code', 'SUCCESS');
		$xml->add_param('return_msg', 'notify ok');
		$this->response->setOutput($xml->make_param_xml());
	}
	
	private function paied_success($orderid, $result) {
		$this->load->model('checkout/order');
		
		if (isset($this->session->data['order_info'])) {
			$order_info = $this->session->data['order_info'];
		}
		else {
			$order_info = $this->model_checkout_order->fastgetOrder($orderid);
		}
		
		if ($order_info == false) {
			$this->log->write('weixin notified, but order can not find in db, order_id='.$orderid);
			return;
		}
		
		if ($order_info['order_status_id'] != 2) {
			$this->log->write('weixin notified, but order is not paying status, order_id='.$orderid.' order_status='.$order_info['order_status_id']);
			return;
		}
		
		$order_info['weixin_pay_result'] = $result;
		if ($order_info['order_type'] == 0) //固定价格订单 状态转换至 待称重
			$order_info['order_status_id'] = 1;
		else if ($order_info['order_type'] == 1) //变价格订单 状态转换至 待配送
			$order_info['order_status_id'] = 3;
		$this->model_checkout_order->fastupdate($orderid, $order_info);
	}
}

?>