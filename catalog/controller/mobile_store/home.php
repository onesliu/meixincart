<?php  
class ControllerMobileStoreHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mobile_store/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/mobile_store/home.tpl';
		} else {
			$this->template = 'default/template/mobile_store/home.tpl';
		}
		
		$this->children = array(
			'mobile_store/content_top',
			'mobile_store/content_bottom',
			'mobile_store/navi',
			'mobile_store/header'
		);

		$this->response->setOutput($this->render());
	}
}
?>