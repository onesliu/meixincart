<?php

class ControllerKfplugin extends Controller { 
	public function index() {
		
		// view template
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/weixin/kfplugin.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/weixin/kfplugin.tpl';
		} else {
			$this->template = 'default/template/weixin/kfplugin.tpl';
		}
		
		$this->response->setOutput($this->render());
	}
	
}

?>