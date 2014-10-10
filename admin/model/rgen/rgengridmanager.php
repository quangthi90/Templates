<?php
class ModelRgenRgenGridmanager extends Model {

	public $settingsTable = 'rgen_gridmanager';

	public function install() {
		$sql = 'CREATE TABLE IF NOT EXISTS`' . DB_PREFIX . $this->settingsTable . '` (
			`rgen_id` int(11) NOT NULL AUTO_INCREMENT,
			`store_id` int(11) NOT NULL DEFAULT "0",
			`group` varchar(32) NOT NULL,
			`mod_id` varchar(64) NOT NULL,
			`value` mediumtext NOT NULL,
			`serialized` tinyint(1) NOT NULL,
			PRIMARY KEY (`rgen_id`)
		)ENGINE=MyISAM DEFAULT CHARSET=utf8;';
		$this->db->query($sql);
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . $this->settingsTable . "`");
	}

	/* SETTINGS FUNCTIONS
	=====================================*/

	public function LastID($limit = 1) {
		$data = array(); 
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . $this->settingsTable . "` ORDER BY `rgen_id` DESC LIMIT " . (int)$limit . "");
		foreach ($query->rows as $result) {
			$data = $result['rgen_id'];
		}
		return $data;
	}

	public function RGenAddSetting($group, $data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");

		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
			}
		}
	}
	public function RGenUpdateSetting($value, $group, $key, $store_id = 0) {
		//$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "';");
		$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $this->db->escape(serialize($value)) . "' WHERE `group` = '" . $this->db->escape($group) . "' AND `key` = '" . $this->db->escape($key) . "' AND `store_id` = '" . (int)$store_id . "'");
	}

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

	public function RGenInsert($group, $data, $store_id = 0) {
		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . $this->settingsTable . " SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `mod_id` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . $this->settingsTable . " SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `mod_id` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
			}
		}
	}

	public function RGenEditValue($group = '', $key = '', $value = '', $store_id = 0) {
		if (!is_array($value)) {
			$this->db->query("UPDATE `" . DB_PREFIX . $this->settingsTable . "` SET `value` = '" . $this->db->escape($value) . "' WHERE `group` = '" . $this->db->escape($group) . "' AND `mod_id` = '" . $this->db->escape($key) . "' AND `store_id` = '" . (int)$store_id . "'");
		} else {
			$this->db->query("UPDATE `" . DB_PREFIX . $this->settingsTable . "` SET `value` = '" . $this->db->escape(serialize($value)) . "' WHERE `group` = '" . $this->db->escape($group) . "' AND `mod_id` = '" . $this->db->escape($key) . "' AND `store_id` = '" . (int)$store_id . "'");
		}
	}

	public function RGenDeleteValue($key, $store_id = 0) {
		$data = $query = $this->db->query("SELECT * FROM " . DB_PREFIX . $this->settingsTable . " WHERE store_id = '" . (int)$store_id . "' AND `mod_id` = '" . $this->db->escape($key) . "'");
		if ($data->num_rows != 0) {
			$this->db->query("DELETE FROM " . DB_PREFIX . $this->settingsTable . " WHERE store_id = '" . (int)$store_id . "' AND `mod_id` = '" . $this->db->escape($key) . "'");	
		}else{
			$data = "error";
		}
		return $data;
	}
	/*=====================================*/

}
?>