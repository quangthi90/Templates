<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Bommer Luu
//Email (PayPal Account): lqthi.khtn@gmail.com
//License: OpenCart 2.0.x
?>
<?php 
class ControllerNewsNews extends Controller {
	private $error = array(); 
	
	public function index() {  
		$this->language->load('news/news');
		
		$this->load->model('news/news');
		$this->load->model('tool/image');
		
		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
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
									
				$category_info = $this->model_news_news->getNewsCategory($npath_id);
				
				if ($category_info) {
					$data['breadcrumbs'][] = array(
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
			$data['related_newss'] = array();
		
			foreach ($this->model_news_news->getRelatedNews($this->request->get['news_id']) as $result) {
			$data['related_newss'][] = array(
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
		
		$news_info = $this->model_news_news->getNews($news_id);
		
		if ($news_info) {
			
			// Count Read start
			$data['new_read_counter_value'] = $news_info['count_read']+1;
			$this->model_news_news->updateNewsReadCounter($this->request->get['news_id'], $data['new_read_counter_value']);
			// Count Read end
			
			$data['news_id'] = $news_id;
			
			$data['date_added'] = $news_info['date_added'];
			$data['date_modified'] = $news_info['date_modified'];
			$data['count_read'] = $news_info['count_read']+1;
			$data['short_description'] = html_entity_decode($news_info['short_description']);  
			$data['description'] = html_entity_decode($news_info['description']);  
			$data['allow_comment'] = $news_info['allow_comment']; 
			$data['comment_permission'] = $news_info['comment_permission']; 
			$data['comment_need_approval'] = $news_info['comment_need_approval'];
			$data['image'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			
			$data['comment_total'] = $this->model_news_news->getTotalCommentsByNewsId($this->request->get['news_id']);
			
			$this->document->setTitle($news_info['title']); 
			$this->document->setDescription($news_info['meta_description']);
			$this->document->setKeywords($news_info['meta_keyword']);
			
			$data['breadcrumbs'][] = array(
				'text'      => $news_info['title'],
				'href'      => $this->url->link('news/news', $npath_url . 'news_id=' . $this->request->get['news_id']),
				'separator' => $this->language->get('text_separator')
			);		
						
		
			$data['heading_title'] = $news_info['title'];
			
			$data['text_updated_on'] = $this->language->get('text_updated_on');
			$data['text_posted_on'] = $this->language->get('text_posted_on');
			$data['text_read'] = $this->language->get('text_read');
			$data['text_times'] = $this->language->get('text_times');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_write_comment'] = $this->language->get('text_write_comment');
			$data['text_note'] = $this->language->get('text_note');
			$data['text_no_comment'] = $this->language->get('text_no_comment');
			$data['button_comment'] = $this->language->get('button_comment');
			$data['text_comments'] = $this->language->get('text_comments');
			$data['text_comment_must_logged'] = $this->language->get('text_comment_must_logged');
			$data['text_related_news'] = $this->language->get('text_related_news');
			$data['text_wait'] = $this->language->get('text_wait');
			
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_comment'] = $this->language->get('entry_comment');
			$data['entry_captcha'] = $this->language->get('entry_captcha');
							
			$data['button_continue'] = $this->language->get('button_continue');
																			
			$data['logged'] = $this->customer->isLogged();
      		$data['continue'] = $this->url->link('common/home');
					
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}  
		
			$data['comments'] = array();
			
			$results = $this->model_news_news->getCommentsByNewsId($this->request->get['news_id'], ($page - 1) * $this->config->get('news_setting_comments_per_page'), $this->config->get('news_setting_comments_per_page'));
			
			foreach ($results as $result) {
				$data['comments'][] = array(
					'name'     => $result['name'],
					'email'     => $result['email'],
					'comment'       => strip_tags($result['comment']),
					'date_added' => $result['date_added']
				);
			}			
		
			$comment_total = $this->model_news_news->getTotalCommentsByNewsId($this->request->get['news_id']);
			
			$pagination = new Pagination();
			$pagination->total = $comment_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('news_setting_comments_per_page'); 
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('news/news', $npath_url . 'news_id=' . $this->request->get['news_id'] . '&page={page}#comment_area');
			
			$data['pagination'] = $pagination->render();

			// Get Comment end

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . 'default/template/news/news.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . 'default/template/news/news.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/news/news.tpl', $data));
			}
			
		}
	}
	
	public function write() {
		$this->language->load('news/news');
		
		$this->load->model('news/news');
		
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
			$this->model_news_news->addComment($this->request->get['news_id'], $this->request->post['name'], $this->request->post['email'], $this->request->post['comment'], 0);
			
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
