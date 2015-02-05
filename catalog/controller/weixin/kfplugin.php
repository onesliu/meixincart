<?php

class ControllerWeixinKfplugin extends Controller { 
	public function index() {
		
		// view template
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/weixin/kfplugin.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/weixin/kfplugin.tpl';
		} else {
			$this->template = 'default/template/weixin/kfplugin.tpl';
		}
		
		$this->children = array(
				'mobile_store/header'
			);
		
		$this->response->setOutput($this->render());
	}
	
}

?>