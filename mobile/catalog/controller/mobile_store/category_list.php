<?php 
class ControllerMobileStoreCategoryList extends Controller {  
	public function index() { 
	
		$this->language->load('product/category');
		
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		
		$this->data['text_empty'] = $this->language->get('text_empty');							
		$this->data['categories'] = array();
		
		$results = $this->model_catalog_category->getCategories(0);
		
		foreach ($results as $result) {
			$data = array(
				'filter_category_id'  => $result['category_id'],
				'filter_sub_category' => true	
			);
						
			$product_total = $this->model_catalog_product->getTotalProducts($data);
			
			$this->data['categories'][] = array(
				'name'  => $result['name'] . ' (' . $product_total . ')',
				'href'  => $this->url->link('mobile_store/category', 'fspath=' . $result['category_id'])
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mobile_store/category_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/mobile_store/category_list.tpl';
		} else {
			$this->template = 'default/template/mobile_store/category_list.tpl';
		}
		
		$this->children = array(
			'mobile_store/column_left',
			'mobile_store/content_top',
			'mobile_store/content_bottom',
			'mobile_store/footer',
			'mobile_store/header'
		);
			
		$this->response->setOutput($this->render());										
  	}
}
?>