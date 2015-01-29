<?php
class ModelFaqFaq extends Controller {
	public function getFAQs() {

		$faqs_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faqs f WHERE f.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		foreach ($query->rows as $result) {
			$faqs_data[] = array(
				'faq_id'             => $result['faq_id'],
				'question'     => $result['question'],
				'answer' => $result['answer']
			);
		}
		
		return $faqs_data;
	}

	public function getFAQbyID($faq_id) {
		$faq_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faqs f WHERE f.faq_id ='". (int)$faq_id . "'");
		
		foreach ($query->rows as $result) {
			$faq_data[] = array(
				'faq_id'             => $result['faq_id'],
				'question'     => $result['question'],
				'answer' => $result['answer']
			);
		}
		
		return $faq_data;
	}

	public function getFAQRelatedbyID($faq_id) {
		$faq_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faqs f WHERE f.faq_id >'". (int)$faq_id . "' LIMIT 5");
		
		foreach ($query->rows as $result) {
			$faq_data[] = array(
				'faq_id'             => $result['faq_id'],
				'question'     => $result['question'],
				'answer' => $result['answer']
			);
		}
		
		return $faq_data;
	}
}