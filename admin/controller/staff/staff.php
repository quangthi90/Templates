<?php 
class ControllerStaffStaff extends Controller { 
	private $error = array();
	private $num_pad = 4;

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
		if (isset($this->request->get['filter_code'])) {
			$filter_code = $this->request->get['filter_code'];
		} else {
			$filter_code = null;
		}

		if (isset($this->request->get['filter_fullname'])) {
			$filter_fullname = $this->request->get['filter_fullname'];
		} else {
			$filter_fullname = null;
		}

		if (isset($this->request->get['filter_day'])) {
			$filter_day = $this->request->get['filter_day'];
		} else {
			$filter_day = null;
		}

		if (isset($this->request->get['filter_month'])) {
			$filter_month = $this->request->get['filter_month'];
		} else {
			$filter_month = null;
		}

		if (isset($this->request->get['filter_year'])) {
			$filter_year = $this->request->get['filter_year'];
		} else {
			$filter_year = null;
		}

		if (isset($this->request->get['filter_salary'])) {
			$filter_salary = $this->request->get['filter_salary'];
		} else {
			$filter_salary = null;
		}

		if (isset($this->request->get['filter_department_id'])) {
			$filter_department_id = $this->request->get['filter_department_id'];
		} else {
			$filter_department_id = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'st.lastname';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . urlencode(html_entity_decode($this->request->get['filter_code'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . urlencode(html_entity_decode($this->request->get['filter_fullname'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_day'])) {
			$url .= '&filter_day=' . urlencode(html_entity_decode($this->request->get['filter_day'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_month'])) {
			$url .= '&filter_month=' . urlencode(html_entity_decode($this->request->get['filter_month'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . urlencode(html_entity_decode($this->request->get['filter_year'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_salary'])) {
			$url .= '&filter_salary=' . urlencode(html_entity_decode($this->request->get['filter_salary'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . urlencode(html_entity_decode($this->request->get['filter_department_id'], ENT_QUOTES, 'UTF-8'));
		}

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
		$this->data['export'] = $this->url->link('staff/staff/export', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['staffs'] = array();

		$data = array(
			'filter_code'	  	=> $filter_code, 
			'filter_fullname'  	=> $filter_fullname,
			'filter_day'	  	=> $filter_day,
			'filter_month'	 	=> $filter_month,
			'filter_year'   	=> $filter_year,
			'filter_salary'   	=> $filter_salary,
			'filter_department_id' 	=> $filter_department_id,
			'sort'            	=> $sort,
			'order'           	=> $order,
			'start' 			=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' 			=> $this->config->get('config_admin_limit')
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
				'code'        => $result['department_code'] . $result['staff_code'],
				'name'        => $result['firstname'] . ' ' . $result['middlename'] . ' ' . $result['lastname'],
				'birthday'    => date($this->language->get('date_format_short'), strtotime($result['birthday'])),
				'salary'      => number_format($result['salary']),
				'department'  => $result['name'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['staff_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_day'] = $this->language->get('text_day');
		$this->data['text_month'] = $this->language->get('text_month');

		$this->data['column_code'] = $this->language->get('column_code');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_birthday'] = $this->language->get('column_birthday');
		$this->data['column_salary'] = $this->language->get('column_salary');
		$this->data['column_department'] = $this->language->get('column_department');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_export'] = $this->language->get('button_export');

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

		$url = '';

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . urlencode(html_entity_decode($this->request->get['filter_code'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . urlencode(html_entity_decode($this->request->get['filter_fullname'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_day'])) {
			$url .= '&filter_day=' . $this->request->get['filter_day'];
		}

		if (isset($this->request->get['filter_month'])) {
			$url .= '&filter_month=' . $this->request->get['filter_month'];
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . $this->request->get['filter_year'];
		}

		if (isset($this->request->get['filter_salary'])) {
			$url .= '&filter_salary=' . $this->request->get['filter_salary'];
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_code'] = $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . '&sort=st.code' . $url, 'SSL');
		$this->data['sort_lastname'] = $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . '&sort=st.lastname' . $url, 'SSL');
		$this->data['sort_birthday'] = $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . '&sort=st.birthday' . $url, 'SSL');
		$this->data['sort_salary'] = $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . '&sort=st.salary' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_code'])) {
			$url .= '&filter_code=' . urlencode(html_entity_decode($this->request->get['filter_code'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_fullname'])) {
			$url .= '&filter_fullname=' . urlencode(html_entity_decode($this->request->get['filter_fullname'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_day'])) {
			$url .= '&filter_day=' . $this->request->get['filter_day'];
		}

		if (isset($this->request->get['filter_month'])) {
			$url .= '&filter_month=' . $this->request->get['filter_month'];
		}

		if (isset($this->request->get['filter_year'])) {
			$url .= '&filter_year=' . $this->request->get['filter_year'];
		}

		if (isset($this->request->get['filter_salary'])) {
			$url .= '&filter_salary=' . $this->request->get['filter_salary'];
		}

		if (isset($this->request->get['filter_department_id'])) {
			$url .= '&filter_department_id=' . $this->request->get['filter_department_id'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $staff_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('staff/staff', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_code'] = $filter_code;
		$this->data['filter_fullname'] = $filter_fullname;
		$this->data['filter_day'] = $filter_day;
		$this->data['filter_month'] = $filter_month;
		$this->data['filter_year'] = $filter_year;
		$this->data['filter_salary'] = $filter_salary;
		$this->data['filter_department_id'] = $filter_department_id;

		$this->data['token'] = $this->session->data['token'];

		// departments
		$this->load->model('department/department');
		$departments = $this->model_department_department->getDepartments();
		$this->data['departments'] = array();
		foreach ($departments as $department) {
			$this->data['departments'][] = array(
				'id' => $department['department_id'],
				'name' => $department['name']
			);
		}

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
		$this->data['text_male'] = $this->language->get('text_male');
		$this->data['text_female'] = $this->language->get('text_female');
		$this->data['text_single'] = $this->language->get('text_single');
		$this->data['text_married'] = $this->language->get('text_married');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_middlename'] = $this->language->get('entry_middlename');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_code'] = $this->language->get('entry_code');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_birthday'] = $this->language->get('entry_birthday');
		$this->data['entry_birthplace'] = $this->language->get('entry_birthplace');
		$this->data['entry_salary'] = $this->language->get('entry_salary');
		$this->data['entry_salary_trial'] = $this->language->get('entry_salary_trial');
		$this->data['entry_department'] = $this->language->get('entry_department');
		$this->data['entry_sex'] = $this->language->get('entry_sex');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_folk'] = $this->language->get('entry_folk');
		$this->data['entry_religion'] = $this->language->get('entry_religion');
		$this->data['entry_marital'] = $this->language->get('entry_marital');
		$this->data['entry_identity_card'] = $this->language->get('entry_identity_card');
		$this->data['entry_valid_from'] = $this->language->get('entry_valid_from');
		$this->data['entry_police_location'] = $this->language->get('entry_police_location');
		$this->data['entry_permanent_address'] = $this->language->get('entry_permanent_address');
		$this->data['entry_present_address'] = $this->language->get('entry_present_address');
		$this->data['entry_phone'] = $this->language->get('entry_phone');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_salary'] = $this->language->get('tab_salary');
		$this->data['tab_data'] = $this->language->get('tab_data');

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

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($staff_info)) {
			$this->data['firstname'] = $staff_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['middlename'])) {
			$this->data['middlename'] = $this->request->post['middlename'];
		} elseif (!empty($staff_info)) {
			$this->data['middlename'] = $staff_info['middlename'];
		} else {
			$this->data['middlename'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($staff_info)) {
			$this->data['lastname'] = $staff_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (!empty($staff_info)) {
			$this->data['code'] = $staff_info['staff_code'];
		} else {
			$this->data['code'] = str_pad($this->model_staff_staff->getLastCode() + 1, $this->num_pad, '0', STR_PAD_LEFT);
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

		if (isset($this->request->post['birthday'])) {
			$this->data['birthday'] = $this->request->post['birthday'];
		} elseif (!empty($staff_info)) {
			$this->data['birthday'] = date('Y-m-d', strtotime($staff_info['birthday']));
		} else {
			$this->data['birthday'] = '';
		}

		if (isset($this->request->post['sex'])) {
			$this->data['sex'] = $this->request->post['sex'];
		} elseif (!empty($staff_info)) {
			$this->data['sex'] = $staff_info['sex'];
		} else {
			$this->data['sex'] = '';
		}

		if (isset($this->request->post['address'])) {
			$this->data['address'] = $this->request->post['address'];
		} elseif (!empty($staff_info)) {
			$this->data['address'] = $staff_info['address'];
		} else {
			$this->data['address'] = '';
		}

		if (isset($this->request->post['marital'])) {
			$this->data['marital'] = $this->request->post['marital'];
		} elseif (!empty($staff_info)) {
			$this->data['marital'] = $staff_info['is_single'];
		} else {
			$this->data['marital'] = '';
		}

		if (isset($this->request->post['identity_card'])) {
			$this->data['identity_card'] = $this->request->post['identity_card'];
		} elseif (!empty($staff_info)) {
			$this->data['identity_card'] = $staff_info['identity_card'];
		} else {
			$this->data['identity_card'] = '';
		}

		if (isset($this->request->post['valid_from'])) {
			$this->data['valid_from'] = $this->request->post['valid_from'];
		} elseif (!empty($staff_info)) {
			$this->data['valid_from'] = $staff_info['valid_from'];
		} else {
			$this->data['valid_from'] = '';
		}

		if (isset($this->request->post['permanent_address'])) {
			$this->data['permanent_address'] = $this->request->post['permanent_address'];
		} elseif (!empty($staff_info)) {
			$this->data['permanent_address'] = $staff_info['permanent_address'];
		} else {
			$this->data['permanent_address'] = '';
		}

		if (isset($this->request->post['present_address'])) {
			$this->data['present_address'] = $this->request->post['present_address'];
		} elseif (!empty($staff_info)) {
			$this->data['present_address'] = $staff_info['present_address'];
		} else {
			$this->data['present_address'] = '';
		}

		if (isset($this->request->post['phone'])) {
			$this->data['phone'] = $this->request->post['phone'];
		} elseif (!empty($staff_info)) {
			$this->data['phone'] = $staff_info['phone'];
		} else {
			$this->data['phone'] = '';
		}

		if (isset($this->request->post['salary'])) {
			$this->data['salary'] = $this->request->post['salary'];
		} elseif (!empty($staff_info)) {
			$this->data['salary'] = $staff_info['salary'];
		} else {
			$this->data['salary'] = '0';
		}

		if (isset($this->request->post['salary_trial'])) {
			$this->data['salary_trial'] = $this->request->post['salary_trial'];
		} elseif (!empty($staff_info)) {
			$this->data['salary_trial'] = $staff_info['salary_trial'];
		} else {
			$this->data['salary_trial'] = '0';
		}

		$this->data['salaries'] = array();
		$this->load->model('salary/type');
		$salaries = $this->model_salary_type->getTypes(array('staff_id' => isset($staff_info) ? $staff_info['staff_id'] : -1));
		foreach ($salaries as $salary) {
			$value = $salary['value'] == null ? $this->data['salary_trial'] * $salary['percent_of_salary'] / 100 : $salary['value'];
			$this->data['salaries'][] = array(
				'id' => $salary['salary_type_id'],
				'name' => $salary['name'],
				'value' => $value
			);
		}
		if ( isset($this->request->post['salaries']) ) {
			foreach ($this->data['salaries'] as $key => $salary) {
				$this->data['salaries'][$key]['value'] = $this->request->post['salaries'][$salary['id']];
			}
		}

		$this->load->model('department/department');
		$departments = $this->model_department_department->getDepartments();
		$this->data['departments'] = array();
		foreach ($departments as $department) {
			$this->data['departments'][] = array(
				'id' => $department['department_id'],
				'name' => $department['name']
			);
		}
		if (isset($this->request->post['department_id'])) {
			$this->data['department_id'] = $this->request->post['department_id'];
		} elseif (!empty($staff_info)) {
			$this->data['department_id'] = $staff_info['department_id'];
		} else {
			$this->data['department_id'] = '';
		}

		$this->load->model('config/city');
		$this->data['cities'] = array();
		$cities = $this->model_config_city->getCities(array('limit' => 1000, 'start' => 0));
		foreach ($cities as $city) {
			$this->data['cities'][] = array(
				'id' => $city['city_id'],
				'name' => $city['city_name']
			);
		}

		if (isset($this->request->post['birthplace_id'])) {
			$this->data['birthplace_id'] = $this->request->post['birthplace_id'];
		} elseif (!empty($staff_info)) {
			$this->data['birthplace_id'] = $staff_info['birthplace_id'];
		} else {
			$this->data['birthplace_id'] = '';
		}

		if (isset($this->request->post['police_location_id'])) {
			$this->data['police_location_id'] = $this->request->post['police_location_id'];
		} elseif (!empty($staff_info)) {
			$this->data['police_location_id'] = $staff_info['police_location_id'];
		} else {
			$this->data['police_location_id'] = '';
		}

		$this->load->model('config/folk');
		$this->data['folks'] = array();
		$folks = $this->model_config_folk->getFolks(array('limit' => 1000, 'start' => 0));
		foreach ($folks as $folk) {
			$this->data['folks'][] = array(
				'id' => $folk['folk_id'],
				'name' => $folk['folk_name']
			);
		}

		if (isset($this->request->post['folk_id'])) {
			$this->data['folk_id'] = $this->request->post['folk_id'];
		} elseif (!empty($staff_info)) {
			$this->data['folk_id'] = $staff_info['folk_id'];
		} else {
			$this->data['folk_id'] = '';
		}

		$this->load->model('config/religion');
		$this->data['religions'] = array();
		$religions = $this->model_config_religion->getreligions(array('limit' => 1000, 'start' => 0));
		foreach ($religions as $religion) {
			$this->data['religions'][] = array(
				'id' => $religion['religion_id'],
				'name' => $religion['religion_name']
			);
		}

		if (isset($this->request->post['religion_id'])) {
			$this->data['religion_id'] = $this->request->post['religion_id'];
		} elseif (!empty($staff_info)) {
			$this->data['religion_id'] = $staff_info['religion_id'];
		} else {
			$this->data['religion_id'] = '';
		}

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

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 15)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['code']) < 1) || (utf8_strlen($this->request->post['code']) > 30)) {
			$this->error['code'] = $this->language->get('error_code');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if ( empty($this->request->post['salary_trial']) ) {
			$this->request->post['salary_trial'] = $this->request->post['salary'] * 0.8;
		}

		$this->load->model('salary/type');
		$salaries = $this->model_salary_type->getTypes();
		foreach ($salaries as $salary) {
			if ( !empty($this->request->post['salaries'][$salary['salary_type_id']]) ) continue;
			$this->request->post['salaries'][$salary['salary_type_id']] = $this->request->post['salary'] * $salary['percent_of_salary'] / 100;
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

	public function export() {
		$this->language->load('staff/staff');

		if (isset($this->request->get['filter_code'])) {
			$filter_code = $this->request->get['filter_code'];
		} else {
			$filter_code = null;
		}

		if (isset($this->request->get['filter_fullname'])) {
			$filter_fullname = $this->request->get['filter_fullname'];
		} else {
			$filter_fullname = null;
		}

		if (isset($this->request->get['filter_day'])) {
			$filter_day = $this->request->get['filter_day'];
		} else {
			$filter_day = null;
		}

		if (isset($this->request->get['filter_month'])) {
			$filter_month = $this->request->get['filter_month'];
		} else {
			$filter_month = null;
		}

		if (isset($this->request->get['filter_year'])) {
			$filter_year = $this->request->get['filter_year'];
		} else {
			$filter_year = null;
		}

		if (isset($this->request->get['filter_salary'])) {
			$filter_salary = $this->request->get['filter_salary'];
		} else {
			$filter_salary = null;
		}

		if (isset($this->request->get['filter_department_id'])) {
			$filter_department_id = $this->request->get['filter_department_id'];
		} else {
			$filter_department_id = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'st.lastname';
		}

		$this->load->model('staff/staff');
		$this->load->model('salary/type');
		$this->load->model('salary/salary');
		$this->load->model('tool/excel');

		$data = array(
			'filter_code'	  	=> $filter_code, 
			'filter_fullname'  	=> $filter_fullname,
			'filter_day'	  	=> $filter_day,
			'filter_month'	 	=> $filter_month,
			'filter_year'   	=> $filter_year,
			'filter_salary'   	=> $filter_salary,
			'filter_department_id' 	=> $filter_department_id,
			'sort'            	=> $sort,
			'start'				=> 0,
			'limit' 			=> 5000
		);

		$staffs = $this->model_staff_staff->getStaffs($data);

		$matrix = array(
			'A1' => 'STT', 
			'B1' => 'Mã NV', 
			'C1' => 'Họ Tên',
			'D1' => 'Họ',
			'E1' => 'Tên Đệm',
			'F1' => 'Tên',
			'G1' => 'Ngày Sinh',
			'H1' => 'Bộ Phận',
			'I1' => 'Lương CB',
			'J1' => 'Lương Thử Việc'
		);

		$types = $this->model_salary_type->getTypes(array('limit' => 100, 'start' => 0));
		$col = 'K';
		foreach ($types as $type) {
			$matrix[$col . '1'] = $type['name'];
			$col++;
		}

		$row = 0;
		foreach ($staffs as $key => $staff) {
			$row = $key + 2;
			$matrix['A' . $row] = $key + 1;
			$matrix['B' . $row] = $staff['department_code'] . $staff['staff_code'];
			$matrix['C' . $row] = $staff['firstname'] . ' ' . $staff['middlename'] . ' ' . $staff['lastname'];
			$matrix['D' . $row] = $staff['firstname'];
			$matrix['E' . $row] = $staff['middlename'];
			$matrix['F' . $row] = $staff['lastname'];
			$matrix['G' . $row] = date('d/m/Y', strtotime($staff['birthday']));
			$matrix['H' . $row] = $staff['name'];
			$matrix['I' . $row] = $staff['salary'];
			$matrix['J' . $row] = $staff['salary_trial'];

			$salaries = $this->model_salary_salary->getSalaries(array('staff_id' => $staff['staff_id']));

			$col = 'J';
			foreach ($types as $type) {
				$col++;
				$matrix[$col . $row] = $salaries[$type['salary_type_id']]['value'];
			}
		}

		$this->model_tool_excel->createExcelFile($matrix, DIR_DOWNLOAD . 'information.xlsx', 'A1:' . $col . $row, true);

		exit;
	}	
}
?>