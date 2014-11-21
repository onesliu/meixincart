<?php   
class ControllerMobileStoreAbout extends Controller {
	public function index() {
		$this->data['title'] = $this->document->getTitle();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mobile_store/about.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/mobile_store/about.tpl';
		} else {
			$this->template = 'default/template/mobile_store/about.tpl';
		}
		
		$this->children = array(
				'mobile_store/titlebar',
				'mobile_store/header'
			);
			
    	$this->response->setOutput($this->render());
	} 	
}
?>