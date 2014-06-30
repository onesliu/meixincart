<?php
class ControllerQingyouOrderQuery extends Controller {
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
					$this->model_qingyou_order->updateOrder($order);
					if (isset($order->products)) {
						foreach($order->products as $product) {
							$this->model_qingyou_order->updateProduct($order->order_id, $product);
						}
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
	
}