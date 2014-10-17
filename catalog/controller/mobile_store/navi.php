<?php   
class ControllerMobileStoreNavi extends Controller {
	protected function index() {
		
		$this->language->load('mobile_store/header');
		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_categories'] = $this->language->get('text_categories');
    	$this->data['text_order'] = $this->language->get('text_order');
    	$this->data['text_checkout'] = $this->language->get('text_checkout');
				
		$this->data['home'] = $this->url->link('mobile_store/home');
		$this->data['category_list'] = $this->url->link('mobile_store/category_list', '', 'SSL');
		$this->data['cart'] = $this->url->link('mobile_store/cart');
		$this->data['order'] = $this->url->link('mobile_store/order', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mobile_store/navi.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/mobile_store/navi.tpl';
		} else {
			$this->template = 'default/template/mobile_store/navi.tpl';
		}
		
    	$this->render();
	} 	
}
?>