<?php   
class ControllerMobileStoreMenu extends Controller {
	public function index() {

		$this->load->model('qingyou/menu');
		$this->load->model('qingyou/food');

		if (!isset($this->request->get['id'])) {
			$this->redirect($this->url->link('mobile_store/home'));
		}
		
		if (isset($this->request->get['menuid'])) {
			$menuid = $this->request->get['menuid'];
		}
		
		$menus = $this->model_qingyou_menu->getMenus($this->request->get['id']);
		
		if (isset($this->request->get['menuid'])) {
			$menuid = $this->request->get['menuid'];
		}
		else {
			$menuid = $menus[0]['id'];
		}
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$dir_img = $this->config->get('config_ssl') . 'image/';
		} else {
			$dir_img = $this->config->get('config_url') . 'image/';
		}
				
		foreach($menus as &$menu) {
			$menu['url'] = $this->url->link('mobile_store/menu', 'menuid='.$menu['id']."&id=".$this->request->get['id']);
			
			if ($menu['id'] == $menuid) {
				$menu['image1'] = $dir_img.$menu['image1'];
				$menu['image2'] = $dir_img.$menu['image2'];
				$menu['image3'] = $dir_img.$menu['image3'];
				
				$menu['menu_food'] = $this->model_qingyou_food->getMenuFood($menu['id']);
				foreach($menu['menu_food'] as &$food) {
					$food['image1'] = $dir_img.$food['image1'];
					$food['image2'] = $dir_img.$food['image2'];
					$food['image3'] = $dir_img.$food['image3'];
					$food['url'] = $this->url->link('mobile_store/food', 'id='.$food['id']);
				}
				
				$menu['sources'] = $this->model_qingyou_food->getFoodSourcesByMenu($menu['id']);
				foreach($menu['sources'] as &$p) {
					$p['weight_show'] = ((int)$p['weight']) . $p['weight_class'];
					$p['price_show'] = $this->currency->format($this->tax->calculate($p['price'], $p['tax_class_id'], $this->config->get('config_tax')));
				}
				
				$m = &$menu;
			}
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mobile_store/menu.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/mobile_store/menu.tpl';
		} else {
			$this->template = 'default/template/mobile_store/menu.tpl';
		}
		
		//$this->request->get['back'] = true;
		$this->data['menus'] = $menus;
		$this->data['menu'] = $m;
		
		$this->children = array(
			'mobile_store/header',
			'mobile_store/navi',
			'mobile_store/titlebar'
		);

		$this->response->setOutput($this->render());
	} 	
}
?>