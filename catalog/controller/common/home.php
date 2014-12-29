<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['home_url'] = HTTP_SERVER;
		$data['product_img_url'] = HTTP_SERVER.'image/catalog/home/product.jpg';
		$data['service_img_url'] = HTTP_SERVER.'image/catalog/home/service.jpg';;

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		// check affiliate
		if ( isset($this->session->data['tracking']) ) {
			$this->load->model('affiliate/affiliate');
			$affiliate = $this->model_affiliate_affiliate->getAffiliateByCode( $this->session->data['tracking'] );
			if ( !$affiliate ) {
				$data['phone'] = $this->config->get('config_telephone');
			} else {
				$data['phone'] = $affiliate['telephone'];
			}
		} else {
			$data['phone'] = $this->config->get('config_telephone');
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}