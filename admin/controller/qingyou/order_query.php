<?php
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerQingyouOrderQuery extends ControllerWeixinWeixin {
	private $error = array();

	public function index() {

		$this->load->model('qingyou/order');
		
		$user = $this->user->getUserInfo();
		$districtid = $user['district_id'];
			
		$history = null;
		if (isset($this->request->get['history']))
			$history = $this->request->get['history'];
			
		$this->data['orders'] = $this->model_qingyou_order->getOrders(null, $districtid, $history);
		
		$this->template = 'qingyou/order_query.tpl';
		
		$this->response->setOutput($this->render());
	}
	
	public function search() {
		
		if (!isset($this->request->get['date'])) {
			$this->errorReturn(-1, 'date参数缺失');
			return;
		}
		
		$date = $this->request->get['date'];
		
		$this->load->model('qingyou/order');
		
		$user = $this->user->getUserInfo();
		$districtid = $user['district_id'];
			
		$this->data['orders'] = $this->model_qingyou_order->searchOrders($date, $districtid);
		
		$this->template = 'qingyou/order_query.tpl';
		
		$this->response->setOutput($this->render());
		
	}
	
	public function commit() {
		$return = new stdClass();
		$return->status = -1;
		
		if (isset($this->request->post['orders'])) {
			$orders = json_decode(htmlspecialchars_decode($this->request->post['orders']));
			
			if ($orders != null) {
				$this->load->model('qingyou/order');
				
				foreach ($orders as $order) {
					if ($this->checkOrderInfo($order) == false) {
						$this->response->setOutput(json_encode($return));
						return;
					}
				}
				
				foreach ($orders as $order) {
					if ($this->model_qingyou_order->updateOrder($order) == true) {
						if (isset($order->products)) {
							foreach($order->products as $product) {
								$this->model_qingyou_order->updateProduct($order->order_id, $product);
							}
						}
						//发送订单状态改变消息
						$this->sendWxMsg($order);
					}
					else {
						$this->log->write("order already updated. orderid=".$order->order_id.",status=".$order->order_status);
					}
				}
				$return->status = 0;
			}
		}

		$this->response->setOutput(json_encode($return));
	}
	
	public function status() {
		$this->load->model('qingyou/order');
		$this->template = 'qingyou/order_query.tpl';
		$this->data['orders'] = $this->model_qingyou_order->getStatus();
		$this->response->setOutput($this->render());
	}

	public function districts() {
		$this->load->model('qingyou/order');
		$this->template = 'qingyou/order_query.tpl';
		$this->data['orders'] = $this->model_qingyou_order->getDistricts();
		$this->response->setOutput($this->render());
	}
	
	public function balance() {
		$this->load->model('qingyou/order');
		
		$user = $this->user->getUserInfo();
		$districtid = $user['district_id'];
		
		$balance = $this->model_qingyou_order->getBalance($districtid);
		$this->response->setOutput(json_encode($balance));
	}
	
	public function setbalance() {
		$this->load->model('qingyou/order');
		
		$user = $this->user->getUserInfo();
		$districtid = $user['district_id'];
		
		$ret = new stdClass();
		$ret->status = -1;
		if ($this->model_qingyou_order->setBalance($districtid) == true)
			$ret->status = 0;
			
		$this->response->setOutput(json_encode($ret));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'qingyou/order_query')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function alertpay() {
		$return = new stdClass();
		$return->status = -1;
		
		if (!isset($this->request->get['order_id'])) {
			$this->response->setOutput(json_encode($return));
			return;
		}
		$order_id = $this->request->get['order_id'];
		
		if ($this->weixin_init() != true) {
			$this->log->write("alertpay: 微信接口初始化出错");
			$this->response->setOutput(json_encode($return));
			return; //首次验证或初始化失败
		}
		
		$this->load->model('qingyou/order');
		$openid = $this->model_qingyou_order->getOrderCustomer($order_id);
		if ($openid == false) {
			$this->log->write("alertpay: 发送客服消息-查询客户出错");
			$this->response->setOutput(json_encode($return));
			return;
		}

		$wxtools = new WeixinTools();
		$msg = $wxtools->makeKfMsg($openid, "text", "亲，您有一笔订单尚未付款。您可以点击之前的付款消息进入订单，然后选择\"微信支付\"或者\"货到付款\"。");
		$res = $wxtools->sendKfMsg($msg, $this->access_token);
		if ($res == false) {
			$this->log->write("alertpay: 发送客服提醒消息出错");
			$this->response->setOutput(json_encode($return));
			return;
		}
		
		$return->status = 0;
		$this->response->setOutput(json_encode($return));
	}
	
	public function sendWxMsg($order) {
		
		if ($this->weixin_init() != true) {
			$this->log->write("sendWxMsg: 微信接口初始化出错");
			return; //首次验证或初始化失败
		}
		
		$openid = $this->model_qingyou_order->getOrderCustomer($order->order_id);
		if ($openid == false) {
			$this->log->write("sendWxMsg: 发送客服消息-查询客户出错");
			return;
		}

		$wxtools = new WeixinTools();
		$messages = $this->prepareWxMsg($order);
		$msg = $wxtools->makeKfMsg($openid, "news", $messages);
		$res = $wxtools->sendKfMsg($msg, $this->access_token);
		if ($res == false) {
			$this->log->write("sendWxMsg: 发送客服提醒消息出错");
		}
	}
	
	private function prepareWxMsg($order) {
		$status = $this->model_qingyou_order->getStatusMsg();
		$content = $status[$order->order_status];
		
		if ($order->order_type == 0)
			$msg = sprintf($content->wxmsg, $order->order_id, $this->currency->format($order->total), $order->order_createtime, $order->productSubject);
		else
			$msg = sprintf($content->wxmsg, $order->order_id, $this->currency->format($order->realtotal), $order->order_createtime, $order->productSubject);
		$url = str_replace("admin/index.php", "pay/weixin.php", $this->url->link2('mobile_store/order/info&order_id='.$order->order_id));
		
		$messages = array();
		$messages[0]["title"] = "交易提醒 " . $content->wxtitle;
		$messages[0]["description"] = $msg;
		$messages[0]["url"] = $url;
		$messages[0]["picurl"] = "";
		return $messages;
	}
	
	private function checkOrderInfo($order) {
		if (!isset($order->order_id)) return false;
		if (!isset($order->order_status)) return false;
		if (!isset($order->total)) return false;
		if (!isset($order->realtotal)) return false;
		if (!isset($order->order_type)) return false;
		if (!isset($order->order_createtime)) return false;
		if (!isset($order->productSubject)) return false;
		return true;
	}
}