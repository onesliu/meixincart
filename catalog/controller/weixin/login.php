<?php 
class ControllerWeixinLogin extends Controller {
	private $error = array();
	
	public function index() {
		// Login override for admin users
		if (!empty($this->request->get['token'])) {
			$this->customer->logout();
			
			$this->load->model('account/customer');
			
			$customer_info = $this->model_account_customer->getCustomerByToken($this->request->get['token']);
			
		 	if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
				$this->redirect($this->url->link('mobile_store/home', '', 'SSL')); 
			}
		}		
		
		if ($this->customer->isLogged()) {  
      		$this->redirect($this->url->link('mobile_store/home', '', 'SSL'));
    	}
	
		if ($this->validate()) {
			unset($this->session->data['guest']);
			
			// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
			if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], HTTP_SERVER) !== false || strpos($this->request->post['redirect'], HTTPS_SERVER) !== false)) {
				$this->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
			} else {
				$this->redirect($this->url->link('mobile_store/home', '', 'SSL')); 
			}
    	}  

		if (isset($this->session->data['success'])) {
    		$this->data['success'] = $this->session->data['success'];
    
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
  	}
  
  	private function validate() {
  		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
  			$email = $this->request->post['email'];
  			$passwd = $this->request->post['password'];
  		}
  		else {
  			$email = $this->request->get['email'];
  			$passwd = $this->request->get['password'];
  		}
    	if (!$this->customer->login($email, $passwd)) {
      		$this->error['warning'] = $this->language->get('error_login');
    	}
	
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}  	
  	}
}
?>