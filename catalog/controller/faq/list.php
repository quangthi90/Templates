<?php
class ControllerFaqList extends Controller {
	private $error = array();

	public function index() {
		
		$this->load->language('faq/list');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['txt_view_answer'] = $this->language->get('txt_view_answer');
		$data['txt_submit_question'] = $this->language->get('txt_submit_question');
		$data['txt_full_name'] = $this->language->get('txt_full_name');
		$data['txt_email'] = $this->language->get('txt_email');
		$data['txt_question_title'] = $this->language->get('txt_question_title');
		$data['txt_question_content'] = $this->language->get('txt_question_content');
		$data['txt_security_code'] = $this->language->get('txt_security_code');
		$data['btn_submit'] = $this->language->get('btn_submit');

		$this->document->setTitle($data['heading_title']);
		$data['submit_action'] = $this->url->link('faq/list');
		$data['captcha_link'] = $this->url->link('tool/captcha');

		$this->load->model('faq/faq');

		$results = $this->model_faq_faq->getFAQs();

		$data['faqs'] = array();

		foreach ($results as $result) {		
					
			$data['faqs'][] = array(
				'faq_id'  => $result['faq_id'],
				'question'=> $result['question'],
				'href'    => $this->url->link('faq/detail', 'faq_id=' . $result['faq_id']),
				'cut_answer' => substr($result['answer'],0,200),
				'answer'  => $result['answer']				
			);
		}

		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/faq/list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/faq/list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/faq/list.tpl', $data));
		}

	}
}
