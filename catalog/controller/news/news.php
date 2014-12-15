<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php 
class ControllerNewsNews extends Controller {
	private $error = array(); 
	
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
		
		$npath_url = '';		
		if (isset($this->request->get['npath'])) {
			$npath = '';
				
			foreach (explode('_', $this->request->get['npath']) as $npath_id) {
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
			$npath_url = 'npath=' . $npath . '&';
		}
		
		// Related News start
		if (isset($this->request->get['news_id'])) {
			$this->data['related_newss'] = array();
		
			foreach ($this->model_catalog_news->getRelatedNews($this->request->get['news_id']) as $result) {
			$this->data['related_newss'][] = array(
				'title' => $result['title'],      
				// 'image' => $this->model_tool_image->resize($result['image'], 100, 100),
				'href'  => $this->url->link('news/news', 'news_id=' . $result['news_id'])								
			);
			}
		}
		// Related News end
		
		if (isset($this->request->get['news_id'])) {
			$news_id = $this->request->get['news_id'];
		} else {
			$news_id = 0;
		}
		
		$news_info = $this->model_catalog_news->getNews($news_id);
		
		if ($news_info) {
			
			// Count Read start
			$this->data['new_read_counter_value'] = $news_info['count_read']+1;
			$this->model_catalog_news->updateNewsReadCounter($this->request->get['news_id'], $this->data['new_read_counter_value']);
			// Count Read end
			
			$this->data['news_id'] = $news_id;
			
			$this->data['date_added'] = $news_info['date_added'];
			$this->data['date_modified'] = $news_info['date_modified'];
			$this->data['count_read'] = $news_info['count_read']+1;
			$this->data['short_description'] = html_entity_decode($news_info['short_description']);  
			$this->data['description'] = html_entity_decode($news_info['description']);  
			$this->data['allow_comment'] = $news_info['allow_comment']; 
			$this->data['comment_permission'] = $news_info['comment_permission']; 
			$this->data['comment_need_approval'] = $news_info['comment_need_approval'];
			$this->data['image'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('news_setting_image_width'), $this->config->get('news_setting_image_height'));
			
			$this->data['comment_total'] = $this->model_catalog_news->getTotalCommentsByNewsId($this->request->get['news_id']);
			
			$this->document->setTitle($news_info['title']); 
			$this->document->setDescription($news_info['meta_description']);
			$this->document->setKeywords($news_info['meta_keyword']);
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $news_info['title'],
				'href'      => $this->url->link('news/news', $npath_url . 'news_id=' . $this->request->get['news_id']),
				'separator' => $this->language->get('text_separator')
			);		
						
		
			$this->data['heading_title'] = $news_info['title'];
			
			$this->data['text_updated_on'] = $this->language->get('text_updated_on');
			$this->data['text_posted_on'] = $this->language->get('text_posted_on');
			$this->data['text_read'] = $this->language->get('text_read');
			$this->data['text_times'] = $this->language->get('text_times');
			$this->data['text_comment'] = $this->language->get('text_comment');
			$this->data['text_write_comment'] = $this->language->get('text_write_comment');
			$this->data['text_note'] = $this->language->get('text_note');
			$this->data['text_no_comment'] = $this->language->get('text_no_comment');
			$this->data['button_comment'] = $this->language->get('button_comment');
			$this->data['text_comments'] = $this->language->get('text_comments');
			$this->data['text_comment_must_logged'] = $this->language->get('text_comment_must_logged');
			$this->data['text_related_news'] = $this->language->get('text_related_news');
			$this->data['text_wait'] = $this->language->get('text_wait');
			
			$this->data['entry_name'] = $this->language->get('entry_name');
			$this->data['entry_email'] = $this->language->get('entry_email');
			$this->data['entry_comment'] = $this->language->get('entry_comment');
			$this->data['entry_captcha'] = $this->language->get('entry_captcha');
							
			$this->data['button_continue'] = $this->language->get('button_continue');
																			
			$this->data['logged'] = $this->customer->isLogged();
      		$this->data['continue'] = $this->url->link('common/home');
					
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}  
		
			$this->data['comments'] = array();
			
			$results = $this->model_catalog_news->getCommentsByNewsId($this->request->get['news_id'], ($page - 1) * $this->config->get('news_setting_comments_per_page'), $this->config->get('news_setting_comments_per_page'));
			
			foreach ($results as $result) {
				$this->data['comments'][] = array(
					'name'     => $result['name'],
					'email'     => $result['email'],
					'comment'       => strip_tags($result['comment']),
					'date_added' => $result['date_added']
				);
			}			
		
			$comment_total = $this->model_catalog_news->getTotalCommentsByNewsId($this->request->get['news_id']);
			
			$pagination = new Pagination();
			$pagination->total = $comment_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('news_setting_comments_per_page'); 
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('news/news', $npath_url . 'news_id=' . $this->request->get['news_id'] . '&page={page}#comment_area');
			
			$this->data['pagination'] = $pagination->render();

			// Get Comment end
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/news.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/news.tpl';
			} else {
				$this->template = 'default/template/news/news.tpl';
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
	
	public function write() {
		$this->language->load('news/news');
		
		$this->load->model('catalog/news');
		
		$json = array();
		
		if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 25)) {
			$json['error'] = $this->language->get('error_name');
		}
		
		if ((strlen(utf8_decode($this->request->post['comment'])) < 25) || (strlen(utf8_decode($this->request->post['comment'])) > 1000)) {
			$json['error'] = $this->language->get('error_comment');
		}
		
    	if ((strlen(utf8_decode($this->request->post['email'])) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$json['error'] = $this->language->get('error_email') . $this->request->post['email'];
    	}

		if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
			$json['error'] = $this->language->get('error_captcha');
		}
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			$this->model_catalog_news->addComment($this->request->get['news_id'], $this->request->post['name'], $this->request->post['email'], $this->request->post['comment'], 0);
			
			$json['success'] = $this->language->get('success_messages_approval');
			$json['success'] = $this->language->get('success_messages');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
		
}
?>
