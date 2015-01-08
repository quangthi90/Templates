<?php
class ModelPluginIntroduce extends Model {
	public function getIntroduce() {
		$setting_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE AND `code` = 'introduce'");

		foreach ($query->rows as $result) {
			$setting_data[$result['key']] = $result['value'];
		}

		return $setting_data;
	}

	public function editIntroduce($data) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE`code` = 'introduce'");

		foreach ($data as $key => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '0', `code` = 'introduce', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "', serialized = '0'");
		}
	}
}