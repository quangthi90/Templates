<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php
class ControllerNewsSetting extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('news/setting');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('news_setting', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_for_category'] = $this->language->get('text_for_category');
		$this->data['text_for_article'] = $this->language->get('text_for_article');
		
		$this->data['entry_news_per_page'] = $this->language->get('entry_news_per_page');
		$this->data['entry_comments_per_page'] = $this->language->get('entry_comments_per_page');
		$this->data['entry_category_thumbnail'] = $this->language->get('entry_category_thumbnail');
		$this->data['entry_article_image'] = $this->language->get('entry_article_image');
		$this->data['entry_width'] = $this->language->get('entry_width');
		$this->data['entry_height'] = $this->language->get('entry_height');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
       		'href'      => $this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		$this->data['action'] = $this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['news_setting_news_per_page'])) {
			$this->data['news_setting_news_per_page'] = $this->request->post['news_setting_news_per_page'];
		} else {
			$this->data['news_setting_news_per_page'] = $this->config->get('news_setting_news_per_page');
		}
		
		if (isset($this->request->post['news_setting_thumbnail_width'])) {
			$this->data['news_setting_thumbnail_width'] = $this->request->post['news_setting_thumbnail_width'];
		} else {
			$this->data['news_setting_thumbnail_width'] = $this->config->get('news_setting_thumbnail_width');
		}
		
		if (isset($this->request->post['news_setting_thumbnail_height'])) {
			$this->data['news_setting_thumbnail_height'] = $this->request->post['news_setting_thumbnail_height'];
		} else {
			$this->data['news_setting_thumbnail_height'] = $this->config->get('news_setting_thumbnail_height');
		}
		
		if (isset($this->request->post['news_setting_comments_per_page'])) {
			$this->data['news_setting_comments_per_page'] = $this->request->post['news_setting_comments_per_page'];
		} else {
			$this->data['news_setting_comments_per_page'] = $this->config->get('news_setting_comments_per_page');
		}	
		
		if (isset($this->request->post['news_setting_image_width'])) {
			$this->data['news_setting_image_width'] = $this->request->post['news_setting_image_width'];
		} else {
			$this->data['news_setting_image_width'] = $this->config->get('news_setting_image_width');
		}
		
		if (isset($this->request->post['news_setting_image_height'])) {
			$this->data['news_setting_image_height'] = $this->request->post['news_setting_image_height'];
		} else {
			$this->data['news_setting_image_height'] = $this->config->get('news_setting_image_height');
		}
		
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->template = 'news/setting.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'news/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>