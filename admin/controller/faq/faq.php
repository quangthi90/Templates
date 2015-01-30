<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Bommer Luu
//Email (PayPal Account): lqthi.khtn@gmail.com
//License: OpenCart 2.0.x
?>
<?php 
class Controllerfaqfaq extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('faq/faq');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('faq/faq');
		 
		$this->getList();
	}

	public function add() {
		$this->load->language('faq/faq');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('faq/faq');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_faq_faq->addFAQ($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('faq/faq', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('faq/faq');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('faq/faq');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_faq_faq->editFAQ($this->request->get['faq_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('faq/faq', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('faq/faq');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('faq/faq');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $faq_id) {
				$this->model_faq_faq->deleteFAQ($faq_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('faq/faq', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	private function getList() {		

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';		

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

   		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('faq/faq', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
									
		$data['add'] = $this->url->link('faq/faq/add', 'token=' . $this->session->data['token'], 'SSL');
		$data['delete'] = $this->url->link('faq/faq/delete', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['faqs'] = array();

		$faq_total = $this->model_faq_faq->getTotalFAQs();
		
		$results = $this->model_faq_faq->getFAQs();

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('faq/list/edit', 'token=' . $this->session->data['token'] . '&faq_id=' . $result['faq_id'], 'SSL')
			);
					
			$data['faqs'][] = array(
				'faq_id'  => $result['faq_id'],
				'question'=> $result['question'],
				'answer'  => $result['answer'],
				'date_added' => $result['date_added'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['faq_id'], $this->request->post['selected']),
				'edit'        => $this->url->link('faq/faq/edit', 'token=' . $this->session->data['token'] . '&faq_id=' . $result['faq_id'] . $url, 'SSL'),
				'delete'      => $this->url->link('faq/faq/delete', 'token=' . $this->session->data['token'] . '&faq_id=' . $result['faq_id'] . $url, 'SSL')
			);
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_question'] = $this->language->get('column_question');
		$data['column_answer'] = $this->language->get('column_answer');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_date_added'] = $this->language->get('column_date_added');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
 
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

		$pagination = new Pagination();
		$pagination->total = $faq_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('faq/list', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($faq_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($faq_total - $this->config->get('config_limit_admin'))) ? $faq_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $faq_total, ceil($faq_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('faq/list.tpl', $data));
	}

	private function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['faq_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
				
		$data['entry_question'] = $this->language->get('entry_question');
		$data['entry_answer'] = $this->language->get('entry_answer');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

    	$data['tab_general'] = $this->language->get('tab_general');	
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('faq/faq', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['faq_id'])) {
			$data['action'] = $this->url->link('faq/faq/add', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('faq/faq/edit', 'token=' . $this->session->data['token'] . '&faq_id=' . $this->request->get['faq_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('faq/faq', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();

    	if (isset($this->request->post['faq_data'])) {
			$data['faq_data'] = $this->request->post['faq_data'];
		} elseif (isset($this->request->get['faq_id'])) {
			$data['faq_data'] = $this->model_faq_faq->getFAQbyID($this->request->get['faq_id']);
		} else {
			$data['faq_data'] = array();
		}

		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('faq/form.tpl', $data));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'faq/faq')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['faq_data'] as $language_id => $value) {
			if (strlen(utf8_decode($value['question'])) < 1) {
				$this->error['question'][$language_id] = $this->language->get('error_warning');
			}
			if (strlen(utf8_decode($value['answer'])) < 1) {
				$this->error['answer'][$language_id] = $this->language->get('error_warning');
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'faq/faq')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}
?>