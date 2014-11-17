<?php 
class ControllerSalaryType extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('salary/type');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('salary/type');

		$this->getList();
	}

	public function insert() {
		$this->language->load('salary/type');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('salary/type');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_salary_type->addType($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('salary/type', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('salary/type');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('salary/type');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_salary_type->editType($this->request->get['type_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('salary/type', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('salary/type');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('salary/type');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $type_id) {
				$this->model_salary_type->deleteType($type_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('salary/type', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('salary/type', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('salary/type/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('salary/type/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['types'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$type_total = $this->model_salary_type->getTotalTypes();

		$results = $this->model_salary_type->getTypes($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('salary/type/update', 'token=' . $this->session->data['token'] . '&type_id=' . $result['salary_type_id'] . $url, 'SSL')
			);

			$this->data['types'][] = array(
				'id' 		  => $result['salary_type_id'],
				'name'        => $result['name'],
				'percent'     => $result['percent_of_salary'] . '%',
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['type_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_percent'] = $this->language->get('column_percent');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_repair'] = $this->language->get('button_repair');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$pagination = new Pagination();
		$pagination->total = $type_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('salary/type', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'salary/type_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_percent'] = $this->language->get('entry_percent');	
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_design'] = $this->language->get('tab_design');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

		if (isset($this->error['percent'])) {
			$this->data['error_percent'] = $this->error['percent'];
		} else {
			$this->data['error_percent'] = array();
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('salary/type', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['type_id'])) {
			$this->data['action'] = $this->url->link('salary/type/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('salary/type/update', 'token=' . $this->session->data['token'] . '&type_id=' . $this->request->get['type_id'], 'SSL');
		}

		$this->data['cancel'] = $this->url->link('salary/type', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['type_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$type_info = $this->model_salary_type->getType($this->request->get['type_id']);
		}

		$this->data['token'] = $this->session->data['token'];		

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($type_info)) {
			$this->data['name'] = $type_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['percent'])) {
			$this->data['percent'] = $this->request->post['percent'];
		} elseif (!empty($type_info)) {
			$this->data['percent'] = $type_info['percent_of_salary'];
		} else {
			$this->data['percent'] = 0;
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($type_info)) {
			$this->data['sort_order'] = $type_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		$this->template = 'salary/type_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'salary/type')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 50)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (empty($this->request->post['percent'])) {
			$this->error['percent'] = $this->language->get('error_percent');
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

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'salary/type')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('salary/type');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_salary_type->gettypes($data);

			foreach ($results as $result) {
				$json[] = array(
					'type_id' => $result['type_id'], 
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}		
}
?>