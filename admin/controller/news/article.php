<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Bommer Luu
//Email (PayPal Account): lqthi.khtn@gmail.com
//License: OpenCart 2.0.x
?>
<?php
class ControllerNewsArticle extends Controller { 
	private $error = array();

	public function index() {
		$this->load->language('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		 
		$this->load->model('news/news');

		$this->getList();
	}

	public function add() {
		$this->load->language('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		   
			$this->model_news_news->addNews($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->response->redirect($this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			if(isset($this->request->post['ignore_date_modified'])){
			$ignore_date_modified = $this->request->post['ignore_date_modified'];
			}else{
			$ignore_date_modified = '';
			}
			
			$this->model_news_news->editNews($this->request->get['news_id'], $this->request->post, $ignore_date_modified);
					
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->response->redirect($this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_news_news->deleteNews($news_id);
				$this->model_news_news->deleteNewsComments($news_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->response->redirect($this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
		} else {
			$filter_title = null;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'nd.title';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		$data['breadcrumbs'] = $this->document->breadcrumbs;					
		$data['add'] = $this->url->link('news/article/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('news/article/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$data['newss'] = array();

		$filter_data = array(
			'filter_title' 	=> $filter_title,
			'sort'  		=> $sort,
			'order' 		=> $order,
			'start' 		=> ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' 		=> $this->config->get('config_limit_admin')
		);
	
		$results = $this->model_news_news->getNewss($filter_data);

		$news_total = $this->model_news_news->getTotalNewss($filter_data);
 
    	foreach ($results as $result) {
			$data['newss'][] = array(
				'news_id' => $result['news_id'],
				'title'      => $result['title'],
				'date_added'      => $result['date_added'],
				'date_modified'      => $result['date_modified'],
				'comment_total' => $this->model_news_news->getTotalCommentsByNewsId($result['news_id']),
				'approved_comment' => $this->model_news_news->getTotalApprovedCommentsByNewsId($result['news_id']),
				'unapproved_comment' => $this->model_news_news->getTotalUnapprovedCommentsByNewsId($result['news_id']),
				'sort_order' => $result['sort_order'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['news_id'], $this->request->post['selected']),
				'edit'        => $this->url->link('news/article/edit', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, 'SSL'),
				'delete'      => $this->url->link('news/article/delete', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, 'SSL')
			);
		}	
	
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_comment'] = $this->language->get('column_comment');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_title'] = $this->language->get('entry_title');
		
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
 
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_title'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . '&sort=nd.title' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . '&sort=nd.date_added' . $url, 'SSL');
		$data['sort_date_modified'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . '&sort=nd.date_modified' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . '&sort=n.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $news_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL') . '&page={page}';
			
		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($news_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($news_total - $this->config->get('config_limit_admin'))) ? $news_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $news_total, ceil($news_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['filter_title'] = $filter_title;

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('news/article_list.tpl', $data));
	}

	private function getForm() {
		$data['text_form'] = !isset($this->request->get['category_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['heading_title'] = $this->language->get('heading_title');
        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_data'] = $this->language->get('tab_data');
        $data['tab_related_news'] = $this->language->get('tab_related_news');
        $data['text_browse'] = $this->language->get('text_browse');
        $data['text_clear'] = $this->language->get('text_clear');	
        $data['text_default'] = $this->language->get('text_default');
        $data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_image_manager'] = $this->language->get('text_image_manager');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_all_user'] = $this->language->get('text_all_user');
        $data['text_member_only'] = $this->language->get('text_member_only');
        $data['text_approved'] = $this->language->get('text_approved');
        $data['text_unapproved'] = $this->language->get('text_unapproved');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_no_comments'] = $this->language->get('text_no_comments');
        $data['text_ignore_date_modified'] = $this->language->get('text_ignore_date_modified');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_short_description'] = $this->language->get('entry_short_description');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_top'] = $this->language->get('entry_top');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_allow_comment'] = $this->language->get('entry_allow_comment');
		$data['entry_comment_permission'] = $this->language->get('entry_comment_permission');
		$data['entry_comment_need_approval'] = $this->language->get('entry_comment_need_approval');
		$data['entry_category'] = $this->language->get('entry_category');

		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_top'] = $this->language->get('help_top');
		$data['help_column'] = $this->language->get('help_column');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['token'] = $this->session->data['token'];
		
		if(isset($this->request->get['news_id'])){
			$data['check_news_id'] = $this->request->get['news_id'];
		}else{
			$data['check_news_id'] = '';
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}
		
	 	if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}
		
		if (isset($this->error['short_description'])) {
			$data['error_short_description'] = $this->error['short_description'];
		} else {
			$data['error_short_description'] = '';
		}
		$this->load->model('news/news');
				
		$data['categories'] = $this->model_news_news->getCategories(0);
		
		if (isset($this->request->post['news_category'])) {
			$data['news_category'] = $this->request->post['news_category'];
		} elseif (isset($this->request->get['news_id'])) {
			$data['news_category'] = $this->model_news_news->getnewsCategories($this->request->get['news_id']);
		} else {
			$data['news_category'] = array();
		}
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		$data['breadcrumbs'] = $this->document->breadcrumbs;						
		if (!isset($this->request->get['news_id'])) {
			$data['action'] = $this->url->link('news/article/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('news/article/edit', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'] . $url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['news_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$news_info = $this->model_news_news->getNews($this->request->get['news_id']);
		}
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['news_description'])) {
			$data['news_description'] = $this->request->post['news_description'];
		} elseif (isset($this->request->get['news_id'])) {
			$data['news_description'] = $this->model_news_news->getNewsDescriptions($this->request->get['news_id']);
		} else {
			$data['news_description'] = array();
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (isset($news_info)) {
			$data['image'] = $news_info['image'];
		} else {
			$data['image'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($news_info) && is_file(DIR_IMAGE . $news_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($news_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		if (isset($this->request->post['top'])) {
			$data['top'] = $this->request->post['top'];
		} elseif (!empty($news_info)) {
			$data['top'] = $news_info['top'];
		} else {
			$data['top'] = 0;
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (isset($news_info)) {
			$data['status'] = $news_info['status'];
		} else {
			$data['status'] = 1;
		}
		
		if (isset($this->request->post['allow_comment'])) {
			$data['allow_comment'] = $this->request->post['allow_comment'];
		} elseif (isset($news_info)) {
			$data['allow_comment'] = $news_info['allow_comment'];
		} else {
			$data['allow_comment'] = 1;
		}
		
		if (isset($this->request->post['comment_permission'])) {
			$data['comment_permission'] = $this->request->post['comment_permission'];
		} elseif (isset($news_info)) {
			$data['comment_permission'] = $news_info['comment_permission'];
		} else {
			$data['comment_permission'] = 0;
		}
		
		if (isset($this->request->post['comment_need_approval'])) {
			$data['comment_need_approval'] = $this->request->post['comment_need_approval'];
		} elseif (isset($news_info)) {
			$data['comment_need_approval'] = $news_info['comment_need_approval'];
		} else {
			$data['comment_need_approval'] = 0;
		}
		
		$this->load->model('setting/store');
		
		$data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['news_store'])) {
			$data['news_store'] = $this->request->post['news_store'];
		} elseif (isset($news_info)) {
			$data['news_store'] = $this->model_news_news->getNewsStores($this->request->get['news_id']);
		} else {
			$data['news_store'] = array(0);
		}		
		
		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($news_info)) {
			$data['keyword'] = $news_info['keyword'];
		} else {
			$data['keyword'] = '';
		}
		
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($news_info)) {
			$data['sort_order'] = $news_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		
		if (isset($this->request->post['ignore_date_modified'])) {
			$data['ignore_date_modified'] = $this->request->post['ignore_date_modified'];
		}else{
			$data['ignore_date_modified'] = '';
		}
		
		// Related News
		$data['newss'] = $this->model_news_news->getNewss(array('sort' => 'n.sort_order'));
		
		if (isset($this->request->post['related_news'])) {
			$data['related_news'] = $this->request->post['related_news'];
		} elseif (isset($news_info)) {
			$data['related_news'] = $this->model_news_news->getRelatedNews($this->request->get['news_id']);
		} else {
			$data['related_news'] = array();
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('news/article_form.tpl', $data));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'news/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['news_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['title'])) < 3) || (strlen(utf8_decode($value['title'])) > 100)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		
			if (strlen(utf8_decode($value['description'])) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_required_data');
			}
			return FALSE;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'news/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_title'])) {
			$this->load->model('news/news');
			
			if (isset($this->request->get['filter_title'])) {
				$filter_title = $this->request->get['filter_title'];
			} else {
				$filter_title = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_title'         => $filter_title,
				'start'               => 0,
				'limit'               => $limit
			);
			
			$results = $this->model_news_news->getNewss($data);
			
			foreach ($results as $result) {			
				$json[] = array(
					'news_id' => $result['news_id'],
					'title'       => html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'),	
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>