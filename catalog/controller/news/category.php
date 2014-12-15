<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php 
class ControllerNewsCategory extends Controller {
	public function index() {  
		$this->language->load('news/news');
		
		$this->load->model('catalog/news');
		$this->load->model('tool/image');
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
			
		if (isset($this->request->get['npath'])) {
			$npath = '';
		
			$parts = explode('_', (string)$this->request->get['npath']);
		
			foreach ($parts as $npath_id) {
				if (!$npath) {
					$npath = $npath_id;
				} else {
					$npath .= '_' . $npath_id;
				}
									
				$category_info = $this->model_catalog_news->getNewsCategory($npath_id);
				
				if ($category_info) {
	       			$this->data['breadcrumbs'][] = array(
   	    				'text'      => $category_info['name'],
						'href'      => $this->url->link('news/category', 'npath=' . $npath),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			$category_id = array_pop($parts);
		} else {
			$category_id = 0;
		}
		
		$category_info = $this->model_catalog_news->getNewsCategory($category_id);
		
		if ($category_info) {
	  		$this->document->setTitle($category_info['name']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);
			
			$this->data['heading_title'] = $category_info['name'];

      		$this->data['text_news_not_found'] = $this->language->get('text_news_not_found');			
			$this->data['text_updated_on'] = $this->language->get('text_updated_on');
			$this->data['text_posted_on'] = $this->language->get('text_posted_on');
			$this->data['text_read'] = $this->language->get('text_read');
			$this->data['text_times'] = $this->language->get('text_times');
			$this->data['text_read_more'] = $this->language->get('text_read_more');
			$this->data['text_comments'] = $this->language->get('text_comments');

			$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');
      		
			$this->data['min_height'] = $this->config->get('news_setting_thumbnail_height');
			
      		// News All		
      		if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}  
				
			$this->data['newss'] = array();
			
			$data = array(
				'sort'  => 'n.sort_order, nd.date_added',
				'order' => 'DESC',
				'start' => ($page - 1) * $this->config->get('news_setting_news_per_page'),
				'limit' => $this->config->get('news_setting_news_per_page'),
				'filter_news_category_id' => $category_id,
			);			
			
			$results = $this->model_catalog_news->getNewss($data);
			foreach ($results as $result) {
				$this->data['newss'][] = array(
					'title' => $result['title'],
					'date_added' => $result['date_added'],
					'date_modified' => $result['date_modified'],
					'description' => html_entity_decode($result['description']),
					'short_description' => html_entity_decode($result['short_description']),
					'count_read' => $result['count_read'],
					'image' => $this->model_tool_image->resize(($result['image']) ? ($result['image']) : 'no_image.jpg', $this->config->get('news_setting_thumbnail_width'), $this->config->get('news_setting_thumbnail_height')),
					'href'  => $this->url->link('news/news', 'npath=' . $npath . '&news_id=' . $result['news_id']),
					'href_comment'  => $this->url->link('news/news', 'npath=' . $npath . '&news_id=' . $result['news_id'] . '#comment_area'),
					'news_comment_count' =>$this->model_catalog_news->getTotalCommentsByNewsId($result['news_id'])
				);
			}
			// News All
			
			// Pagination All News start      		
			$filter = array();
			$filter['filter_news_category_id'] = $category_id;
			$news_total = $this->model_catalog_news->getTotalNews($filter);
		
			$pagination = new Pagination();
			$pagination->total = $news_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('news_setting_news_per_page'); 
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('news/category', 'npath=' . $this->request->get['npath'] . '&page={page}');
		
			$this->data['pagination'] = $pagination->render();
			// Pagination All News end

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/category.tpl';
			} else {
				$this->template = 'default/template/news/category.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
		
			$this->response->setOutput($this->render());
    	} else {
			$url = '';
			
			if (isset($this->request->get['npath'])) {
				$url .= '&npath=' . $this->request->get['npath'];
			}
												
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
											
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('news/category', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
					
			$this->response->setOutput($this->render());
		}
	}
}
?>
