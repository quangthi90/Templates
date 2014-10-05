<?php
class ModelRgenRgenBanners extends Model {

	public $settingsTable = 'rgen_banners';
	public $descriptionTable = 'rgen_banners_description';
	
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
			$data['image_data'][$result['banner_id']]['id'] = $result['banner_id'];
			$data['image_data'][$result['banner_id']]['title'][$result['language_id']] = $result['title'];
			$data['image_data'][$result['banner_id']]['image'][$result['language_id']] = $result['image'];
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