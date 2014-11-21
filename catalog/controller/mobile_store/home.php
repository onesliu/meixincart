<?php  
class ControllerMobileStoreHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$dir_img = $this->config->get('config_ssl') . 'image/';
		} else {
			$dir_img = $this->config->get('config_url') . 'image/';
		}
		$this->data['logo'] = $dir_img . 'logo.png';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mobile_store/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/mobile_store/home.tpl';
		} else {
			$this->template = 'default/template/mobile_store/home.tpl';
		}
		
		$this->children = array(
			'mobile_store/titlebar',
			'mobile_store/navi',
			'mobile_store/header'
		);

		$this->response->setOutput($this->render());
	}
}
?>