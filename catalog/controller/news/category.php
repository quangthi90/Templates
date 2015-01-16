<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Bommer Luu
//Email (PayPal Account): lqthi.khtn@gmail.com
//License: OpenCart 2.0.x
?>
<?php 
class ControllerNewsCategory extends Controller {
	public function index() {  
		$this->language->load('news/news');
		
		$this->load->model('news/category');
		$this->load->model('news/news');
		$this->load->model('tool/image');
		
		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
			
		if (isset($this->request->get['path'])) {
			$path = '';
		
			$parts = explode('_', (string)$this->request->get['path']);
		
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
									
				$category_info = $this->model_news_category->getNewsCategory($path_id);
				
				if ($category_info) {
	       			$data['breadcrumbs'][] = array(
   	    				'text'      => $category_info['name'],
						'href'      => $this->url->link('news/category', 'path=' . $path),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			$category_id = array_pop($parts);
		} else {
			$category_id = 0;
		}
		
		$category_info = $this->model_news_category->getNewsCategory($category_id);
		
		if ($category_info) {
	  		$this->document->setTitle($category_info['name']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

			$data['heading_title'] = $category_info['name'];

      		$data['text_news_not_found'] = $this->language->get('text_news_not_found');			
			$data['text_updated_on'] = $this->language->get('text_updated_on');
			$data['text_posted_on'] = $this->language->get('text_posted_on');
			$data['text_read'] = $this->language->get('text_read');
			$data['text_times'] = $this->language->get('text_times');
			$data['text_read_more'] = $this->language->get('text_read_more');
			$data['text_comments'] = $this->language->get('text_comments');

			$data['button_continue'] = $this->language->get('button_continue');

      		$data['continue'] = $this->url->link('common/home');
      		
			$data['min_height'] = $this->config->get('config_image_popup_height');
			
      		// News All		
      		if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}  
				
			$data['newss'] = array();
			
			$filter_data = array(
				'sort'  => 'n.sort_order, nd.date_added',
				'order' => 'DESC',
				'start' => ($page - 1) * $this->config->get('news_setting_news_per_page'),
				// 'limit' => $this->config->get('news_setting_news_per_page'),
				'limit' => 100,
				'filter_news_category_id' => $category_id,
			);			
			
			$results = $this->model_news_news->getNewss($filter_data);

			foreach ($results as $result) {
				$data['newss'][] = array(
					'title' => $result['title'],
					'date_added' => $result['date_added'],
					'date_modified' => $result['date_modified'],
					'description' => html_entity_decode($result['description']),
					'short_description' => html_entity_decode($result['short_description']),
					'count_read' => $result['count_read'],
					'image' => $this->model_tool_image->resize(($result['image']) || is_file($result['image']) ? ($result['image']) : 'no_image.jpg', $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					'href'  => $this->url->link('news/news', 'path=' . $path . '&news_id=' . $result['news_id']),
					'href_comment'  => $this->url->link('news/news', 'path=' . $path . '&news_id=' . $result['news_id'] . '#comment_area'),
					// 'news_comment_count' =>$this->model_news_category->getTotalCommentsByNewsId($result['news_id'])
				);
			}
			// News All
			
			// Pagination All News start      		
			// $filter = array();
			// $filter['filter_news_category_id'] = $category_id;
			// $news_total = $this->model_news_category->getTotalNews($filter);
		
			// $pagination = new Pagination();
			// $pagination->total = $news_total;
			// $pagination->page = $page;
			// $pagination->limit = $this->config->get('news_setting_news_per_page'); 
			// $pagination->text = $this->language->get('text_pagination');
			// $pagination->url = $this->url->link('news/category', 'path=' . $this->request->get['path'] . '&page={page}');
		
			// $data['pagination'] = $pagination->render();
			// Pagination All News end

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . 'default/template/news/category.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . 'default/template/news/category.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/news/category.tpl', $data));
			}
    	} else {
			$url = '';
			
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
												
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
											
			$data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('news/category', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$data['heading_title'] = $this->language->get('text_error');

      		$data['text_error'] = $this->language->get('text_error');

      		$data['button_continue'] = $this->language->get('button_continue');

      		$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . 'default/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . 'default/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}
}
?>
