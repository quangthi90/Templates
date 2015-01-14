<?php
class ControllerProductCategories extends Controller {
	public function index() {
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$data['categories'] = array();
		$data['products'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$filter_data = array(
				'filter_category_id' => $category['category_id'],
				'start'				 => 0,
				'limit'              => 1000
			);

			$data['products'][$category['category_id']] = array();
			
			$products = $this->model_catalog_product->getProducts($filter_data);

			foreach ($products as $product) {
				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				$data['products'][$category['category_id']][] = array(
					'product_id'  => $product['product_id'],
					'thumb'       => $image,
					'name'        => $product['name'],
					'price'       => $price,
					'href'        => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}

			if (count($products) > 0) {
				$data['categories'][] = array(
					'id' 	   => $category['category_id'],
					'name'     => $category['name'],
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['button_cart'] = $this->language->get('button_cart');

		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/categories.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/categories.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/product/categories.tpl', $data));
		}
	}
}