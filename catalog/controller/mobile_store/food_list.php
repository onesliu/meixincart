<?php   
class ControllerMobileStoreFoodList extends Controller {
	public function index() {
		
		$this->load->model('qingyou/food');
		
		if (($this->request->server['REQUEST_METHOD'] == 'GET') && isset($this->request->get['menuid'])) {
			$this->data['menu_food'] = $this->model_qingyou_food->getMenuFood($this->request->get['menuid']);
		}
		elseif (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->valid()) {
			$this->data['menu_food'] = $this->model_qingyou_food->getAllFood($this->request->post['key'], $this->request->post['attrs']);
		}
		else {
			$this->children = array(
				'mobile_store/not_found',
			);
			
			$this->response->setOutput($this->render());
			return;
		}
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$dir_img = $this->config->get('config_ssl') . 'image/';
		} else {
			$dir_img = $this->config->get('config_url') . 'image/';
		}
	
		foreach($this->data['menu_food'] as &$food) {
			$food['image1'] = $dir_img.$food['image1'];
			$food['image2'] = $dir_img.$food['image2'];
			$food['image3'] = $dir_img.$food['image3'];
			$food['url'] = $this->url->link('mobile_store/food', 'id='.$food['id']);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mobile_store/food_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/mobile_store/food_list.tpl';
		} else {
			$this->template = 'default/template/mobile_store/food_list.tpl';
		}
		
		$this->response->setOutput($this->render());
	}
	
	private function valid() {
		if (!isset($this->request->post['key']) && !isset($this->request->post['attrs']))
			return false;
			
		return true;
	}
}
?>