<?php
class ModelRgenRgenContentblocks extends Model {

	public $settingsTable = 'rgen_contentblocks';
	public $descriptionTable = 'rgen_contentblocks_description';
	
	/* DESCRIPTION FUNCTIONS
	=====================================*/
	public function RGenGetDescription($mod_id, $store_id = 0) {
		$data = array(); 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->descriptionTable . " WHERE store_id = '" . (int)$store_id . "' AND `mod_id` = '" . $this->db->escape($mod_id) . "'");
		//echo "<pre>".print_r($query->rows,true)."</pre>";
		foreach ($query->rows as $result) {
			$data[$mod_id] = $result['mod_id'];
			$data['main_title'][$result['language_id']] = $result['section_title'];
			$data['description'][$result['language_id']] = $result['description'];
			$data['description1'][$result['language_id']] = $result['description1'];
			$data['mod_data'][$result['moddata_id']]['id'] = $result['moddata_id'];
			$data['mod_data'][$result['moddata_id']]['title'][$result['language_id']] = $result['title'];
			$data['mod_data'][$result['moddata_id']]['image'][$result['language_id']] = $result['image'];
			$data['mod_data'][$result['moddata_id']]['short_description'][$result['language_id']] = $result['short_description'];

		}
		return $data;
	}

	/* SETTINGS FUNCTIONS
	=====================================*/
	public function RGenGetAll($group, $store_id = 0) {
		$data = array(); 
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->settingsTable . " WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['mod_id']] = $result['value'];
			} else {
				$data[$result['mod_id']] = unserialize($result['value']);
			}
		}
		return $data;
	}

	public function RGenGetValue($key, $store_id = 0) {
		$data = array(); 
		//SELECT * FROM `oc_rgen_custom` WHERE store_id = 0 AND `key` = 'rgen_custom_module1'
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->settingsTable . " WHERE store_id = '" . (int)$store_id . "' AND `mod_id` = '" . $this->db->escape($key) . "'");
		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['mod_id']] = $result['value'];
			} else {
				$data[$result['mod_id']] = unserialize($result['value']);
			}
		}
		return $data;
	}
	/*=====================================*/
}

?>