<?php
class ControllerProductCategories extends Controller {
	public function index() {

		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/categories.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/categories.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/product/categories.tpl', $data));
		}
	}
}