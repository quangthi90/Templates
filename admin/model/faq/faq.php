<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Bommer Luu
//Email (PayPal Account): lqthi.khtn@gmail.com
//License: OpenCart 2.0.x
?>
<?php
class Modelfaqfaq extends Model {
	
   	public function addFAQ($data) {
   		foreach ($data['faq_data'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "faqs SET title = '" . $this->db->escape($value['title']) . "', question = '" . $this->db->escape($value['question']) . "', answer = '" . $this->db->escape($value['answer']) . "', language_id = '" . (int)$language_id . "', date_added = '" . date('Y-m-d H:i:s') . "'");
		}		
	}
	
	public function editFAQ($faq_id, $data) {
		foreach ($data['faq_data'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "faqs SET question = '" . $this->db->escape($value['question']) . "', answer = '" . $this->db->escape($value['answer']) . "', language_id = '" . (int)$language_id . "' WHERE faq_id = '" . (int)$faq_id . "'");
		}
	}
	
	public function deleteFAQ($faq_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "faqs WHERE faq_id = '" . (int)$faq_id . "'");
	} 
	
	public function getFAQs() {

		$faqs_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faqs f WHERE f.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY date_added DESC");
		
		foreach ($query->rows as $result) {
			$faqs_data[] = array(
				'faq_id'     => $result['faq_id'],
				'title'      => $result['title'],
				'question'   => $result['question'],
				'answer'     => $result['answer'],
				'date_added' => $result['date_added']
			);
		}
		
		return $faqs_data;
	}
	
	public function getFAQbyID($faq_id) {
		$faq_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "faqs f WHERE f.faq_id ='". (int)$faq_id . "'");
		
		foreach ($query->rows as $result) {
			$faq_data[$result['language_id']] = array(
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
?>