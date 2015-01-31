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

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}


		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_limit_admin');
		}

		$url = '';		

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$filter_data = array(			
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$this->load->model('faq/faq');

		$results = $this->model_faq_faq->getFAQs($filter_data);

		$data['faqs'] = array();

		foreach ($results as $result) {		
					
			$data['faqs'][] = array(
				'faq_id'  => $result['faq_id'],
				'title'   => $result['title'],
				'question'=> $result['question'],
				'href'    => $this->url->link('faq/detail', 'faq_id=' . $result['faq_id']),
				'answer'  => $result['answer']				
			);
		}

		$faq_total = $this->model_faq_faq->getTotalFAQs();

		$pagination = new Pagination();
		$pagination->total = $faq_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('faq/list', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($faq_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($faq_total - $this->config->get('config_limit_admin'))) ? $faq_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $faq_total, ceil($faq_total / $this->config->get('config_limit_admin')));

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
