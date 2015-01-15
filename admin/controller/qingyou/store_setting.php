<?php
class ControllerQingyouStoreSetting extends Controller {
	private $error = array();
 
	public function index() {
		$this->language->load('qingyou/store_setting'); 

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('wxstore', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('qingyou/store_setting', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data = $this->model_setting_setting->getSetting('wxstore');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['label_minum_order'] = $this->language->get('minum_order');
		$this->data['label_help_interval'] = $this->language->get('help_interval');
		$this->data['label_shipping_interval'] = $this->language->get('shipping_interval');
		
		$this->data['minum_order'] = (isset($data['minum_order']))?$data['minum_order']:'';
		$this->data['help_interval'] = (isset($data['help_interval']))?$data['help_interval']:'';
		$this->data['shipping_interval'] = (isset($data['shipping_interval']))?$data['shipping_interval']:'';
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['minum_order'])) {
			$this->data['error_minum_order'] = $this->error['minum_order'];
		} else {
			$this->data['error_minum_order'] = '';
		}
		
 		if (isset($this->error['help_interval'])) {
			$this->data['error_help_interval'] = $this->error['help_interval'];
		} else {
			$this->data['error_help_interval'] = '';
		}

 		if (isset($this->error['shipping_interval'])) {
			$this->data['error_shipping_interval'] = $this->error['shipping_interval'];
		} else {
			$this->data['error_shipping_interval'] = '';
		}
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('qingyou/store_setting', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('qingyou/store_setting', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('qingyou/store_setting', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->template = 'qingyou/store_setting.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
		
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'qingyou/store_setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['minum_order']) {
			$this->error['minum_order'] = '起送价格必须大于0';
		}

		if (!$this->request->post['help_interval']) {
			$this->error['help_interval'] = '必须大于0';
		}

		if (!$this->request->post['shipping_interval']) {
			$this->error['shipping_interval'] = '必须大于0';
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
}
?>