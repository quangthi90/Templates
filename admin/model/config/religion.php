<?php
class ModelConfigReligion extends Model {
	public function addReligion($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "religion SET religion_name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', sort_order = '" . (int)$data['sort_order'] . "'";
		$this->db->query($sql);
	}

	public function editReligion($religion_id, $data) {
		$sql = "UPDATE " . DB_PREFIX . "religion SET religion_name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE religion_id = $religion_id";
		$this->db->query($sql);
	}

	public function deleteReligion($religion_id) {
		$sql = "UPDATE " . DB_PREFIX . "religion SET deleted = 1 WHERE religion_id = '" . (int)$religion_id . "'";
		$this->db->query($sql);
	}

	public function getReligion($religion_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "religion WHERE religion_id = $religion_id AND deleted = 0");

		return $query->row;
	} 

	public function getReligions($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "religion WHERE deleted = 0";

		$sql .= " ORDER BY sort_order, religion_name COLLATE utf8_spanish_ci";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
// print($sql); exit;
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalReligions() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "religion WHERE deleted = 0");

		return $query->row['total'];
	}
}
?>