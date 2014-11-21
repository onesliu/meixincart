<?php   
class ControllerMobileStoreFood extends Controller {
	public function index() {
		
		$this->load->model('qingyou/food');
		
		if (!isset($this->request->get['id'])) {
			$this->redirect($this->url->link('mobile_store/home'));
		}
		
		$food = $this->model_qingyou_food->getFood($this->request->get['id']);
		$food['attrs'] = $this->model_qingyou_food->getFoodAttrs($this->request->get['id']);
		$sources = $this->model_qingyou_food->getFoodSources($this->request->get['id']);
		$food['makestep'] = $this->model_qingyou_food->getMakeSteps($this->request->get['id']);
		
		foreach($sources as &$p) {
			$p['weight_show'] = ((int)$p['weight']) . $p['weight_class'];
			$p['price_show'] = $this->currency->format($this->tax->calculate($p['price'], $p['tax_class_id'], $this->config->get('config_tax')));
		}
		
		$this->data['sources'] = $sources;
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$dir_img = $this->config->get('config_ssl') . 'image/';
		} else {
			$dir_img = $this->config->get('config_url') . 'image/';
		}
	
		if (isset($food['image1']) && $food['image1'] != '')
			$food['image1'] = $dir_img.$food['image1'];
		else
			$food['image1'] = null;
		if (isset($food['image2']) && $food['image2'] != '')
			$food['image2'] = $dir_img.$food['image2'];
		else
			$food['image2'] = null;
		if (isset($food['image3']) && $food['image3'] != '')
			$food['image3'] = $dir_img.$food['image3'];
		else
			$food['image3'] = null;
		
		$this->data['food'] = $food;
		
		$this->request->get['back'] = true;
		$this->data['logoicon'] = $dir_img.'logoicon.png';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mobile_store/food.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/mobile_store/food.tpl';
		} else {
			$this->template = 'default/template/mobile_store/food.tpl';
		}
		
		$this->children = array(
			'mobile_store/navi',
			'mobile_store/header',
			'mobile_store/titlebar'
		);
		
		$this->response->setOutput($this->render());
	}
	
}
?>