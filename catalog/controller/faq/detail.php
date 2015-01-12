<?php
class ControllerFaqDetail extends Controller {
	
	public function index() {

		$this->load->language('faq/detail');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['txt_related_question'] = $this->language->get('txt_related_question');
		$data['txt_question'] = $this->language->get('txt_question');

		$this->document->setTitle($data['heading_title']);
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/faq/detail.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/faq/detail.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/faq/detail.tpl', $data));
		}
	}
}
