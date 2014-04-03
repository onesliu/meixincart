<?php
class ControllerWeixinSetting extends Controller {
	private $error = array();
 
	public function index() {
		$this->language->load('weixin/setting'); 

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('weixin/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('config', $this->request->post);

			if ($this->config->get('config_currency_auto')) {
				$this->load->model('localisation/currency');
		
				$this->model_localisation_currency->updateCurrencies();
			}	
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['weixin_token'] = $this->language->get('weixin_token');
		$this->data['weixin_appid'] = $this->language->get('weixin_appid');
		$this->data['weixin_appsecret'] = $this->language->get('weixin_appsecret');
		
 		if (isset($this->error['token'])) {
			$this->data['error_token'] = $this->error['token'];
		} else {
			$this->data['error_token'] = '';
		}
		
 		if (isset($this->error['appid'])) {
			$this->data['error_appid'] = $this->error['appid'];
		} else {
			$this->data['error_appid'] = '';
		}

 		if (isset($this->error['appsecret'])) {
			$this->data['error_appsecret'] = $this->error['appsecret'];
		} else {
			$this->data['error_appsecret'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('weixin/setting', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'weixin/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['config_token']) {
			$this->error['token'] = $this->language->get('error_token');
		}

		if (!$this->request->post['config_appid']) {
			$this->error['appid'] = $this->language->get('error_appid');
		}

		if (!$this->request->post['config_appsecret']) {
			$this->error['appsecret'] = $this->language->get('error_appsecret');
		}
	}
}
?>