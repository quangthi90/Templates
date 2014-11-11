<?php 
class ControllerStaffStaff extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('staff/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/staff');

		$this->getList();
	}

	public function insert() {
		$this->language->load('staff/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/staff');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_staff_staff->addstaff($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('staff/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/staff');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_staff_staff->editstaff($this->request->get['staff_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('staff/staff');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('staff/staff');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $staff_id) {
				$this->model_staff_staff->deletestaff($staff_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href'      => $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('staff/staff/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('staff/staff/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['staffs'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$staff_total = $this->model_staff_staff->getTotalstaffs();

		$results = $this->model_staff_staff->getstaffs($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('staff/staff/update', 'token=' . $this->session->data['token'] . '&staff_id=' . $result['staff_id'] . $url, 'SSL')
			);

			$this->data['staffs'][] = array(
				'staff_id' 	  => $result['staff_id'],
				'code'        => $result['staff_code'],
				'name'        => $result['fullname'],
				'birthday'    => date($this->language->get('date_format_short'), strtotime($result['birthday'])),
				'salary'      => number_format($result['salary']),
				'selected'    => isset($this->request->post['selected']) && in_array($result['staff_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_code'] = $this->language->get('column_code');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_birthday'] = $this->language->get('column_birthday');
		$this->data['column_salary'] = $this->language->get('column_salary');
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
		$pagination->total = $staff_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'staff/staff_list.tpl';
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
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		$this->data['entry_filter'] = $this->language->get('entry_filter');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_top'] = $this->language->get('entry_top');
		$this->data['entry_column'] = $this->language->get('entry_column');		
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

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('staff/staff', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['staff_id'])) {
			$this->data['action'] = $this->url->link('staff/staff/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('staff/staff/update', 'token=' . $this->session->data['token'] . '&staff_id=' . $this->request->get['staff_id'], 'SSL');
		}

		$this->data['cancel'] = $this->url->link('staff/staff', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['staff_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$staff_info = $this->model_staff_staff->getstaff($this->request->get['staff_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['staff_description'])) {
			$this->data['staff_description'] = $this->request->post['staff_description'];
		} elseif (isset($this->request->get['staff_id'])) {
			$this->data['staff_description'] = $this->model_staff_staff->getstaffDescriptions($this->request->get['staff_id']);
		} else {
			$this->data['staff_description'] = array();
		}

		if (isset($this->request->post['path'])) {
			$this->data['path'] = $this->request->post['path'];
		} elseif (!empty($staff_info)) {
			$this->data['path'] = $staff_info['path'];
		} else {
			$this->data['path'] = '';
		}

		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($staff_info)) {
			$this->data['parent_id'] = $staff_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}

		$this->load->model('staff/filter');

		if (isset($this->request->post['staff_filter'])) {
			$filters = $this->request->post['staff_filter'];
		} elseif (isset($this->request->get['staff_id'])) {		
			$filters = $this->model_staff_staff->getstaffFilters($this->request->get['staff_id']);
		} else {
			$filters = array();
		}

		$this->data['staff_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_staff_filter->getFilter($filter_id);

			if ($filter_info) {
				$this->data['staff_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}	

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['staff_store'])) {
			$this->data['staff_store'] = $this->request->post['staff_store'];
		} elseif (isset($this->request->get['staff_id'])) {
			$this->data['staff_store'] = $this->model_staff_staff->getstaffStores($this->request->get['staff_id']);
		} else {
			$this->data['staff_store'] = array(0);
		}			

		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($staff_info)) {
			$this->data['keyword'] = $staff_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($staff_info)) {
			$this->data['image'] = $staff_info['image'];
		} else {
			$this->data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($staff_info) && $staff_info['image'] && file_exists(DIR_IMAGE . $staff_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($staff_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['top'])) {
			$this->data['top'] = $this->request->post['top'];
		} elseif (!empty($staff_info)) {
			$this->data['top'] = $staff_info['top'];
		} else {
			$this->data['top'] = 0;
		}

		if (isset($this->request->post['column'])) {
			$this->data['column'] = $this->request->post['column'];
		} elseif (!empty($staff_info)) {
			$this->data['column'] = $staff_info['column'];
		} else {
			$this->data['column'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($staff_info)) {
			$this->data['sort_order'] = $staff_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($staff_info)) {
			$this->data['status'] = $staff_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		if (isset($this->request->post['staff_layout'])) {
			$this->data['staff_layout'] = $this->request->post['staff_layout'];
		} elseif (isset($this->request->get['staff_id'])) {
			$this->data['staff_layout'] = $this->model_staff_staff->getstaffLayouts($this->request->get['staff_id']);
		} else {
			$this->data['staff_layout'] = array();
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'staff/staff_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'staff/staff')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['staff_description'] as $language_id => $value) {
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
		if (!$this->user->hasPermission('modify', 'staff/staff')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}

	protected function validateRepair() {
		if (!$this->user->hasPermission('modify', 'staff/staff')) {
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
			$this->load->model('staff/staff');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_staff_staff->getstaffs($data);

			foreach ($results as $result) {
				$json[] = array(
					'staff_id' => $result['staff_id'], 
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