<?php 
class ControllerConfigBirthplace extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('config/birthplace');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('config/birthplace');

		$this->getList();
	}

	public function insert() {
		$this->language->load('config/birthplace');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('config/birthplace');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_config_birthplace->addbirthplace($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('config/birthplace', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('config/birthplace');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('config/birthplace');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_config_birthplace->editbirthplace($this->request->get['birthplace_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('config/birthplace', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('config/birthplace');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('config/birthplace');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $birthplace_id) {
				$this->model_config_birthplace->deletebirthplace($birthplace_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('config/birthplace', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href'      => $this->url->link('config/birthplace', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('config/birthplace/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('config/birthplace/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['birthplaces'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$birthplace_total = $this->model_config_birthplace->getTotalbirthplaces();

		$results = $this->model_config_birthplace->getbirthplaces($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('config/birthplace/update', 'token=' . $this->session->data['token'] . '&birthplace_id=' . $result['birthplace_id'] . $url, 'SSL')
			);

			$this->data['birthplaces'][] = array(
				'id' 		  => $result['birthplace_id'],
				'name'        => $result['name'],
				'sort_order'        => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['birthplace_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
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
		$pagination->total = $birthplace_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('config/birthplace', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'config/birthplace_list.tpl';
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

		$this->data['entry_name'] = $this->language->get('entry_name');
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
			'href'      => $this->url->link('config/birthplace', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['birthplace_id'])) {
			$this->data['action'] = $this->url->link('config/birthplace/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('config/birthplace/update', 'token=' . $this->session->data['token'] . '&birthplace_id=' . $this->request->get['birthplace_id'], 'SSL');
		}

		$this->data['cancel'] = $this->url->link('config/birthplace', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['birthplace_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$birthplace_info = $this->model_config_birthplace->getbirthplace($this->request->get['birthplace_id']);
		}

		$this->data['token'] = $this->session->data['token'];		

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($birthplace_info)) {
			$this->data['name'] = $birthplace_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($birthplace_info)) {
			$this->data['sort_order'] = $birthplace_info['sort_order'];
		} else {
			$this->data['sort_order'] = 1;
		}

		$this->template = 'config/birthplace_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'config/birthplace')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 50)) {
			$this->error['name'] = $this->language->get('error_name');
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
		if (!$this->user->hasPermission('modify', 'config/birthplace')) {
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