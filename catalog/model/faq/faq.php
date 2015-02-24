<?php
class ModelFaqFaq extends Controller {
	public function getFAQs($data) {
		$language_id = (int)$this->config->get('config_language_id');
		$language_id = 1;

		$sql = "SELECT * FROM " . DB_PREFIX . "faqs f WHERE f.language_id = '" . $language_id . "' ORDER BY date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$faqs_data = array();
		
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$faqs_data[] = array(
				'faq_id'             => $result['faq_id'],
				'title'     => $result['title'],
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
				'title'     => $result['title'],
				'question'     => $result['question'],
				'answer' => $result['answer'],
				'date_added' => $result['date_added']
			);
		}
		
		return $faq_data;
	}

	public function getFAQRelatedbyID($date_added) {
		$faq_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faqs f WHERE f.date_added <'". $date_added . "' LIMIT 5");
		
		foreach ($query->rows as $result) {
			$faq_data[] = array(
				'faq_id'             => $result['faq_id'],
				'title'     => $result['title'],
				'question'     => $result['question'],
				'answer' => $result['answer']
			);
		}
		
		return $faq_data;
	}

	public function getTotalFAQs() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "faqs");
		
		return $query->row['total'];
	}	
}