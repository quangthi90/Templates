<?php
class ModelConfigMajor extends Model {
	public function addMajor($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "major SET major_name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', sort_order = '" . (int)$data['sort_order'] . "'";
		$this->db->query($sql);
	}

	public function editMajor($major_id, $data) {
		$sql = "UPDATE " . DB_PREFIX . "major SET major_name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE major_id = $major_id";
		$this->db->query($sql);
	}

	public function deleteMajor($major_id) {
		$sql = "UPDATE " . DB_PREFIX . "major SET deleted = 1 WHERE major_id = '" . (int)$major_id . "'";
		$this->db->query($sql);
	}

	public function getMajor($major_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "major WHERE major_id = $major_id AND deleted = 0");

		return $query->row;
	} 

	public function getMajors($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "major WHERE deleted = 0";

		$sql .= " ORDER BY sort_order, major_name COLLATE utf8_spanish_ci";

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

	public function getTotalMajors() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "major WHERE deleted = 0");

		return $query->row['total'];
	}
}
?>