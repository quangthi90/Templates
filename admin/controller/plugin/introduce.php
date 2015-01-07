<?php 
class ControllerPluginIntroduce extends Controller { 
	private $error = array();
 
	public function index() {
		$this->load->language('plugin/introduce');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

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

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => $this->url->link('plugin/introduce', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		$data['breadcrumbs'] = $this->document->breadcrumbs;

		$data['entry_image_video'] = $this->language->get('entry_image_video');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_link'] = $this->language->get('entry_link');

		$data['tab_col_1'] = $this->language->get('tab_col_1');
        $data['tab_col_2'] = $this->language->get('tab_col_2');
        $data['tab_col_3'] = $this->language->get('tab_col_3');

        $data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

        $this->load->model('setting/setting');
        $introduce = $this->model_setting_setting->getSetting('introduce');

        // Column 1
        if (isset($this->request->post['introduce_col_1_html'])) {
			$data['introduce_col_1_html'] = $this->request->post['introduce_col_1_html'];
		} elseif (isset($introduce['introduce_col_1_html'])) {
			$data['introduce_col_1_html'] = $introduce['introduce_col_1_html'];
		} else {
			$data['introduce_col_1_html'] = '';
		}

		if (isset($this->request->post['introduce_col_1_title'])) {
			$data['introduce_col_1_title'] = $this->request->post['introduce_col_1_title'];
		} elseif (isset($introduce['introduce_col_1_title'])) {
			$data['introduce_col_1_title'] = $introduce['introduce_col_1_title'];
		} else {
			$data['introduce_col_1_title'] = '';
		}

		if (isset($this->request->post['introduce_col_1_description'])) {
			$data['introduce_col_1_description'] = $this->request->post['introduce_col_1_description'];
		} elseif (isset($introduce['introduce_col_1_description'])) {
			$data['introduce_col_1_description'] = $introduce['introduce_col_1_description'];
		} else {
			$data['introduce_col_1_description'] = '';
		}

		if (isset($this->request->post['introduce_col_1_link'])) {
			$data['introduce_col_1_link'] = $this->request->post['introduce_col_1_link'];
		} elseif (isset($introduce['introduce_col_1_link'])) {
			$data['introduce_col_1_link'] = $introduce['introduce_col_1_link'];
		} else {
			$data['introduce_col_1_link'] = '';
		}

		// Column 2
        if (isset($this->request->post['introduce_col_2_html'])) {
			$data['introduce_col_2_html'] = $this->request->post['introduce_col_2_html'];
		} elseif (isset($introduce['introduce_col_2_html'])) {
			$data['introduce_col_2_html'] = $introduce['introduce_col_2_html'];
		} else {
			$data['introduce_col_2_html'] = '';
		}

		if (isset($this->request->post['introduce_col_2_title'])) {
			$data['introduce_col_2_title'] = $this->request->post['introduce_col_2_title'];
		} elseif (isset($introduce['introduce_col_2_title'])) {
			$data['introduce_col_2_title'] = $introduce['introduce_col_2_title'];
		} else {
			$data['introduce_col_2_title'] = '';
		}

		if (isset($this->request->post['introduce_col_2_description'])) {
			$data['introduce_col_2_description'] = $this->request->post['introduce_col_2_description'];
		} elseif (isset($introduce['introduce_col_2_description'])) {
			$data['introduce_col_2_description'] = $introduce['introduce_col_2_description'];
		} else {
			$data['introduce_col_2_description'] = '';
		}

		if (isset($this->request->post['introduce_col_2_link'])) {
			$data['introduce_col_2_link'] = $this->request->post['introduce_col_2_link'];
		} elseif (isset($introduce['introduce_col_2_link'])) {
			$data['introduce_col_2_link'] = $introduce['introduce_col_2_link'];
		} else {
			$data['introduce_col_2_link'] = '';
		}

		// Column 3
        if (isset($this->request->post['introduce_col_3_html'])) {
			$data['introduce_col_3_html'] = $this->request->post['introduce_col_3_html'];
		} elseif (isset($introduce['introduce_col_3_html'])) {
			$data['introduce_col_3_html'] = $introduce['introduce_col_3_html'];
		} else {
			$data['introduce_col_3_html'] = '';
		}

		if (isset($this->request->post['introduce_col_3_link'])) {
			$data['introduce_col_3_link'] = $this->request->post['introduce_col_3_link'];
		} elseif (isset($introduce['introduce_col_3_link'])) {
			$data['introduce_col_3_link'] = $introduce['introduce_col_3_link'];
		} else {
			$data['introduce_col_3_link'] = '';
		}

		$data['action'] = $this->url->link('plugin/introduce/edit', 'token=' . $this->session->data['token'], 'SSL');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('plugin/introduce.tpl', $data));
	}

	public function edit() {
		$this->load->language('plugin/introduce');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_setting->editSetting('introduce', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->index();
	}

	public function validateForm() {
		if (!$this->user->hasPermission('modify', 'plugin/introduce')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// Column 1
		if (utf8_strlen($this->request->post['introduce_col_1_html']) < 5 ) {
			$this->error['warning'] = $this->language->get('error_html');
		
		} elseif (utf8_strlen($this->request->post['introduce_col_1_title']) < 3 || utf8_strlen($this->request->post['introduce_col_1_title']) > 50 ) {
			$this->error['warning'] = $this->language->get('error_title');
		
		} elseif (utf8_strlen($this->request->post['introduce_col_1_description']) < 3 || utf8_strlen($this->request->post['introduce_col_1_description']) > 250 ) {
			$this->error['warning'] = $this->language->get('error_description');
		
		} elseif (utf8_strlen($this->request->post['introduce_col_1_link']) < 3 ) {
			$this->error['warning'] = $this->language->get('error_link');
		
		// Column 2
		} elseif (utf8_strlen($this->request->post['introduce_col_2_html']) < 5 ) {
			$this->error['warning'] = $this->language->get('error_html');
		
		} elseif (utf8_strlen($this->request->post['introduce_col_2_title']) < 3 || utf8_strlen($this->request->post['introduce_col_2_title']) > 50 ) {
			$this->error['warning'] = $this->language->get('error_title');
		
		} elseif (utf8_strlen($this->request->post['introduce_col_2_description']) < 3 || utf8_strlen($this->request->post['introduce_col_2_description']) > 250 ) {
			$this->error['warning'] = $this->language->get('error_description');
		
		} elseif (utf8_strlen($this->request->post['introduce_col_2_link']) < 3 ) {
			$this->error['warning'] = $this->language->get('error_link');

		// Column 3
		} elseif (utf8_strlen($this->request->post['introduce_col_3_html']) < 5 ) {
			$this->error['warning'] = $this->language->get('error_html');
		
		} elseif (utf8_strlen($this->request->post['introduce_col_3_link']) < 3 ) {
			$this->error['warning'] = $this->language->get('error_link');
		}

		return !$this->error;
	}
}
?>