<?php
include_once(DIR_APPLICATION."controller/weixin/weixin.php");

class ControllerQingyouOrderQuery extends ControllerWeixinWeixin {
	private $error = array();

	public function index() {

		$this->load->model('qingyou/order');
		
		//$last_orderid = $this->request->get['last_orderid'];
		$districtid = $this->request->get['districtid'];
		$history = $this->request->get['history'];
		$this->data['orders'] = $this->model_qingyou_order->getOrders(null, $districtid, $history);
		
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
	
	public function sendWxMsg($order) {
		
		if ($this->weixin_init() != true) {
			return; //首次验证或初始化失败
		}
		
		$msg = $this->prepareWxMsg($order);
		if ($msg == false) return;
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$this->access_token;
		$res = $this->postToWx($url, $msg);
	}
	
	private function prepareWxMsg($order) {
		$openid = $this->model_qingyou_order->getOrderCustomer($order->order_id);
		if ($openid == false) return false;
		
		$status = $this->model_qingyou_order->getStatusMsg();
		$content = $status[$order->order_status];
		
		switch((int)$order->order_status) {
			case 2:
				$msg = sprintf($content, $order->order_id, $order->total, $order->order_createtime, $order->productSubject);
				$url = $this->url->link2('mobile_store/order');
				break;
			default:
				$msg = sprintf($content, $order->order_id, $order->total, $order->order_createtime, $order->productSubject);
				$url = $this->url->link2('mobile_store/order');
				break;
		} 
		
		/*
		$omsg = new stdClass();
		$omsg->touser = $openid;
		$omsg->msgtype = "news";
		$omsg->news = new stdClass();
		$omsg->news->articles = array();
		$omsg->news->articles[0] = new stdClass();
		$omsg->news->articles[0]->title = "交易提醒";
		$omsg->news->articles[0]->description = $msg;
		$omsg->news->articles[0]->url = $url;
		$omsg->news->articles[0]->picurl = "";
		*/
		
		$messages = array();
		$messages[0]["title"] = "交易提醒";
		$messages[0]["description"] = $msg;
		$messages[0]["url"] = $url;
		$messages[0]["picurl"] = "";
		return $this->makeNewsMsg($openid, $messages);
	}
}