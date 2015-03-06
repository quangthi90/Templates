<?php
class ControllerInformationSitemap extends Controller {
	public function index() {
		$this->load->language('information/sitemap');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/sitemap')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_password'] = $this->language->get('text_password');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_history'] = $this->language->get('text_history');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_search'] = $this->language->get('text_search');
		$data['text_information'] = $this->language->get('text_information');
		$data['text_contact'] = $this->language->get('text_contact');

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories_1 = $this->model_catalog_category->getCategories(0);

		foreach ($categories_1 as $category_1) {
			$level_2_data = array();

			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

			foreach ($categories_2 as $category_2) {
				$level_3_data = array();

				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'name' => $category_3['name'],
						'href' => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id'])
					);
				}

				$level_2_data[] = array(
					'name'     => $category_2['name'],
					'children' => $level_3_data,
					'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'])
				);
			}

			$data['categories'][] = array(
				'name'     => $category_1['name'],
				'children' => $level_2_data,
				'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'])
			);
		}

		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['edit'] = $this->url->link('account/edit', '', 'SSL');
		$data['password'] = $this->url->link('account/password', '', 'SSL');
		$data['address'] = $this->url->link('account/address', '', 'SSL');
		$data['history'] = $this->url->link('account/order', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['search'] = $this->url->link('product/search');
		$data['contact'] = $this->url->link('information/contact');

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			$data['informations'][] = array(
				'title' => $result['title'],
				'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
			);
		}

		//BOMMER Link Names
		$data['text_product_links'] = $this->language->get('text_product_links');
		$data['text_news_links'] = $this->language->get('text_news_links');
		$data['text_other_links'] = $this->language->get('text_other_links');

		// BOMMER All Product
		$data['product_list'] = $this->url->link('product/categories');
		$data['text_productlist'] = $this->language->get('text_productlist');

		// BOMMER News Menu
		$this->load->model('news/category');
		$this->load->model('news/news');

		$categories = $this->model_news_category->getCategories(0);
		$data['news_categories'] = array();
		$common_config = $this->config->get('common');
		foreach ($categories as $category) {
			if ((!empty($this->session->data['tracking']) || $this->affiliate->isLogged()) && $category['news_category_id'] == $common_config['affiliate']['remove_news_id']) continue;
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_news_category->getCategories($category['news_category_id']);

				foreach ($children as $child) {
					if ($child['top']){
						// Level 3
						$children_news_data = array();
						$child_newss = $this->model_news_news->getNewss(array('filter_news_category_id' => $child['news_category_id']));
						foreach ($child_newss as $child_news) {
							if ($child_news['top']){
								$children_news_data[] = array(
									'name'  => $child_news['title'],
									'href'  => $this->url->link('news/news', 'news_id=' . $child_news['news_id']),
									'sort_order' => $child_news['sort_order']
								);
							}
						}
						$children_data[] = array(
							'name'  => $child['name'],
							'href'  => $this->url->link('news/category', 'path=' . $category['news_category_id'] . '_' . $child['news_category_id']),
							'sort_order' => $child['sort_order'],
							'children' => $children_news_data
						);
					}
				}

				$newss = $this->model_news_news->getNewss(array('filter_news_category_id' => $category['news_category_id']));

				foreach ($newss as $news) {
					if ($news['top']){
						$children_data[] = array(
							'name'  => $news['title'],
							'href'  => $this->url->link('news/news', 'news_id=' . $news['news_id']),
							'sort_order' => $news['sort_order']
						);
					}
				}

				uasort($children_data, function($a, $b){
					if ($a['sort_order'] == $b['sort_order']) {
				        return 0;
					}
					return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
				});
				
				// Level 1
				$data['news_categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('news/category', 'path=' . $category['news_category_id'])
				);
			}
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/sitemap.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/sitemap.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/sitemap.tpl', $data));
		}
	}
}