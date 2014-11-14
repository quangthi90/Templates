<?php 
class ControllerDepartmentDepartment extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('department/department');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('department/department');

		$this->getList();
	}

	public function insert() {
		$this->language->load('department/department');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('department/department');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_department_department->adddepartment($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('department/department', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('department/department');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('department/department');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_department_department->editdepartment($this->request->get['department_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('department/department', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('department/department');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('department/department');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $department_id) {
				$this->model_department_department->deletedepartment($department_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('department/department', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href'      => $this->url->link('department/department', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('department/department/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('department/department/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['departments'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$department_total = $this->model_department_department->getTotaldepartments();

		$results = $this->model_department_department->getdepartments($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('department/department/update', 'token=' . $this->session->data['token'] . '&department_id=' . $result['department_id'] . $url, 'SSL')
			);

			$this->data['departments'][] = array(
				'department_id' 	  	=> $result['department_id'],
				'code'        			=> $result['code'],
				'name'        			=> $result['name'],
				'order'	    			=> $result['order'],
				'selected'    			=> isset($this->request->post['selected']) && in_array($result['department_id'], $this->request->post['selected']),
				'action'      			=> $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_code'] = $this->language->get('column_code');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_order'] = $this->language->get('column_order');
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
		$pagination->total = $department_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('department/department', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'department/department_list.tpl';
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

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_middlename'] = $this->language->get('entry_middlename');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_code'] = $this->language->get('entry_code');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_birthday'] = $this->language->get('entry_birthday');
		$this->data['entry_salary'] = $this->language->get('entry_salary');		
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_layout'] = $this->language->get('entry_layout');

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

		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = array();
		}

		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = array();
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('department/department', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['department_id'])) {
			$this->data['action'] = $this->url->link('department/department/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('department/department/update', 'token=' . $this->session->data['token'] . '&department_id=' . $this->request->get['department_id'], 'SSL');
		}

		$this->data['cancel'] = $this->url->link('department/department', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['department_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$department_info = $this->model_department_department->getdepartment($this->request->get['department_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($department_info)) {
			$this->data['firstname'] = $department_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['middlename'])) {
			$this->data['middlename'] = $this->request->post['middlename'];
		} elseif (!empty($department_info)) {
			$this->data['middlename'] = $department_info['middlename'];
		} else {
			$this->data['middlename'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($department_info)) {
			$this->data['lastname'] = $department_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (!empty($department_info)) {
			$this->data['code'] = $department_info['department_code'];
		} else {
			$this->data['code'] = '';
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		// } elseif (!empty($department_info)) {
		// 	$this->data['image'] = $department_info['image'];
		} else {
			$this->data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		// } elseif (!empty($department_info) && $department_info['image'] && file_exists(DIR_IMAGE . $department_info['image'])) {
		// 	$this->data['thumb'] = $this->model_tool_image->resize($department_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['birthday'])) {
			$this->data['birthday'] = $this->request->post['birthday'];
		} elseif (!empty($department_info)) {
			$this->data['birthday'] = date($this->language->get('date_format_short'), strtotime($department_info['birthday']));
		} else {
			$this->data['birthday'] = '';
		}

		if (isset($this->request->post['salary'])) {
			$this->data['salary'] = $this->request->post['salary'];
		} elseif (!empty($department_info)) {
			$this->data['salary'] = $department_info['salary'];
		} else {
			$this->data['salary'] = '';
		}

		$this->template = 'department/department_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'department/department')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['department_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
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

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'department/department')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}

	protected function validateRepair() {
		if (!$this->user->hasPermission('modify', 'department/department')) {
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
			$this->load->model('department/department');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_department_department->getdepartments($data);

			foreach ($results as $result) {
				$json[] = array(
					'department_id' => $result['department_id'], 
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