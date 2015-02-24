<?php
class ControllerFaqDetail extends Controller {
	
	public function index() {

		$this->load->language('faq/detail');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['txt_related_question'] = $this->language->get('txt_related_question');
		$data['txt_question'] = $this->language->get('txt_question');

		$this->load->model('faq/faq');
		$path = '';

		$parts = explode('_', (string)$this->request->get['faq_id']);

		$faq_id = (int)array_pop($parts);

		$results = $this->model_faq_faq->getFAQbyID($faq_id);

		foreach ($results as $result) {		
			$data['title'] = $result['title'];
			$data['question'] = $result['question'];
			$data['answer'] = html_entity_decode($result['answer']);
			$data['date_added'] = $result['date_added'];
		}

		$data['faqs'] = array();

		$relates = $this->model_faq_faq->getFAQRelatedbyID($data['date_added']);

		foreach ($relates as $relate) {		
					
			$data['faqs'][] = array(
				'faq_id'  => $relate['faq_id'],
				'title'   => $relate['title'],
				'question'=> $relate['question'],
				'href'    => $this->url->link('faq/detail', 'faq_id=' . $relate['faq_id']),
				'answer'  => $relate['answer']				
			);
		}

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
