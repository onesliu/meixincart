<?php
class ControllerMobileStoreCategoryMore extends Controller {  
	public function index() {
		
		if (!isset($this->request->get['fspath']))
			return;
		
		if (!isset($this->request->get['limit']))
			return;
		
		if (!isset($this->request->get['page']))
			return;
		
		// -- FILTER ATTRIBUTES MODULE --
		$this->load->model('catalog/category');
		
		$this->load->model('catalog/product');
		$this->load->model('mobile_store/product');
		$this->load->model('tool/image'); 
		
		$this->data['button_cart'] = $this->language->get('button_cart');
		
		if (isset($this->request->get['filter_price'])){
			$filter_price = $this->request->get['filter_price'];
			list($filter_price_from, $filter_price_to) = preg_split('/\|/', $filter_price);
		} else {
			$filter_price = '';
			$filter_price_from = '';
			$filter_price_to = '';
		}
		
		if (isset($this->request->get['filter_manufacturer'])){
			$filter_manufacturer = implode("," , preg_split('/\-/', $this->request->get['filter_manufacturer']));
		} else {
			$filter_manufacturer = array();
		}
		
		if (isset($this->request->get['filter_attributes'])){
			$filter_attributes = implode("," , preg_split('/\-/', html_entity_decode($this->request->get['filter_attributes'])));
		} else {
			$filter_attributes = array();
		}
		// -- STOP FILTER ATTRIBUTES MODULE --
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		$page = $this->request->get['page'];
		$limit = $this->request->get['limit'];
		
		$path = '';
	
		$parts = explode('_', (string)$this->request->get['fspath']);
	
		foreach ($parts as $path_id) {
			if (!$path) {
				$path = $path_id;
			} else {
				$path .= '_' . $path_id;
			}
								
			$category_info = $this->model_catalog_category->getCategory($path_id);
			
			if ($category_info) {
       			$this->data['breadcrumbs'][] = array(
       				'text'      => $category_info['name'],
					'href'      => $this->url->link('mobile_store/category', 'fspath=' . $path),
        			'separator' => $this->language->get('text_separator')
        		);
			}
		}		
	
		$category_id = array_pop($parts);
		
		$this->data['products'] = array();
		
		$data = array(
			'filter_category_id' => $category_id, 
			'filter_sub_category'=> true, 
			// -- STOP FILTER ATTRIBUTES MODULE --
			'filter_price'       => $filter_price,
			'filter_price_from'  => $filter_price_from,
			'filter_price_to'    => $filter_price_to,
			'filter_manufacturer'=> $filter_manufacturer,
			'filter_attributes'  => $filter_attributes,
			// -- STOP FILTER ATTRIBUTES MODULE -
			'sort'               => $sort,
			'order'              => $order,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit
		);
		
		$product_total = $this->model_mobile_store_product->getTotalProducts($data); 
		
		$results = $this->model_mobile_store_product->getProducts($data);
		
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('mobile_store_image_width'), $this->config->get('mobile_store_image_height'));
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', $this->config->get('mobile_store_image_width'), $this->config->get('mobile_store_image_height'));
			}
			
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
			
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}	
			
			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
			} else {
				$tax = false;
			}				
			
			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}
			
			$this->data['products'][] = array(
				'product_id'  => $result['product_id'],
				'thumb'       => $image,
				'name'        => $result['name'],
				'description' => mb_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'price'       => $price,
				'special'     => $special,
				'tax'         => $tax,
				'rating'      => $result['rating'],
				'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'        => $this->url->link('mobile_store/product', 'fspath=' . $this->request->get['fspath'] . '&product_id=' . $result['product_id'])
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mobile_store/category_more.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/mobile_store/category_more.tpl';
		} else {
			$this->template = 'default/template/mobile_store/category_more.tpl';
		}
		
		$this->response->setOutput($this->render());										
		
	}
}