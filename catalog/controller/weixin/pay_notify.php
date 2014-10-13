<?php
include_once(DIR_APPLICATION."controller/weixin/lib/wxtools.php");
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerWeixinPayNotify extends ControllerWeixinWeixin { 
	public function index() {
		
		if ($this->weixin_init() != true) {
			return; //棣栨楠岃瘉鎴栧垵濮嬪寲澶辫触
		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$xmlstr = file_get_contents("php://input");
		
			$resHelper = new PayHelper();
			$res = $resHelper->parse_response($xmlstr);
			if (isset($res->return_code) == false || isset($res->return_msg) == false ||
				(string)$res->return_code != 'SUCCESS') {
				$this->log->write("weixin notify paied fail: \n". $xmlstr);
				$this->success(); //杩斿洖閫氱煡姝ｅ父鎺ユ敹
				return;
			}
			
			if ($resHelper->sign_verify($this->partnerkey) != true) {
				$this->log->write("weixin notify sign verify error: \n". $xmlstr);
				$this->error(); //杩斿洖閫氱煡鏍￠獙閿欒
				return;
			}
			
			if (isset($res->result_code) == false || (string)$res->result_code != 'SUCCESS') {
				$this->success(); //杩斿洖閫氱煡姝ｅ父鎺ユ敹
				return;
			}
			
			$this->paied_success($res->out_trade_no, $xmlstr); //鏇存柊鏁版嵁搴撹鍗曟敮浠樻垚鍔�
			$this->success(); //杩斿洖閫氱煡姝ｅ父鎺ユ敹
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
		if ($order_info['order_type'] == 0) //鍥哄畾浠锋牸璁㈠崟 鐘舵�佽浆鎹㈣嚦 寰呯О閲�
			$order_info['order_status_id'] = 1;
		else if ($order_info['order_type'] == 1) //鍙樹环鏍艰鍗� 鐘舵�佽浆鎹㈣嚦 寰呴厤閫�
			$order_info['order_status_id'] = 3;
		$this->model_checkout_order->fastupdate($orderid, $order_info);
	}
}

?>