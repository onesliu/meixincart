<?php  
class ControllerCommonContentTop extends Controller {
	protected function index() {
		$this->load->model('design/layout');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('catalog/information');
		
		if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
		} else {
			$route = 'common/home';
		}
		
		$layout_id = 0;
		
		if ($route == 'product/category' && isset($this->request->get['path'])) {
			$path = explode('_', (string)$this->request->get['path']);
				
			$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));			
		}
		
		if ($route == 'product/product' && isset($this->request->get['product_id'])) {
			$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
		}
		
		if ($route == 'information/information' && isset($this->request->get['information_id'])) {
			$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
		}
		
		if (!$layout_id) {
			$layout_id = $this->model_design_layout->getLayout($route);
		}
				
		if (!$layout_id) {
			$layout_id = $this->config->get('config_layout_id');
		}

		$module_data = array();
		
		$this->load->model('setting/extension');
		
		$extensions = $this->model_setting_extension->getExtensions('module');		
		
		foreach ($extensions as $extension) {
//OMF start
			$isMobileExtension = false;

			if(strpos($extension['code'], '_mobile') !== false){
				$isMobileExtension = true;
			}//OMF end 
			
			$modules = $this->config->get($extension['code'] . '_module');
			

						if($this->isVisitorMobile()) { //OMF If our client is a mobile device 
			
			if ($modules) {
				foreach ($modules as $module) {
					//OMF start
						if ($module['layout_id'] == $layout_id && $module['position'] == 'content_top' && $module['status'] && $isMobileExtension) { //load only mobile extensions
							$module_data[] = array(
								'code'       => $extension['code'],
								'setting'    => $module,
								'sort_order' => $module['sort_order']
							);
						}
					}
				}
			} else { // Load extensions normally
				if ($modules) {
					foreach ($modules as $module) {
						if ($module['layout_id'] == $layout_id && $module['position'] == 'content_top' && $module['status'] && !$isMobileExtension) { //omitting the mobile ones
							$module_data[] = array(
								'code'       => $extension['code'],
								'setting'    => $module,
								'sort_order' => $module['sort_order']
							);
						}
					}
				}
			}//OMF end
			
			








		}
		
		$sort_order = array(); 
	  
		foreach ($module_data as $key => $value) {
      		$sort_order[$key] = $value['sort_order'];
    	}
		
		array_multisort($sort_order, SORT_ASC, $module_data);
		
		$this->data['modules'] = array();
		
		foreach ($module_data as $module) {
			$module = $this->getChild('module/' . $module['code'], $module['setting']);
			
			if ($module) {
				$this->data['modules'][] = $module;
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/content_top.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/content_top.tpl';
		} else {
			$this->template = 'default/template/common/content_top.tpl';
		}
								
		$this->render();
	}
}
?>