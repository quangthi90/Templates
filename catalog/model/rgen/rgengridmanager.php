<?php
class ModelRgenRgenGridmanager extends Model {

	public $settingsTable = 'rgen_gridmanager';

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