<?php
class ModelConfigDegree extends Model {
	public function addDegree($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "degree SET degree_name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', sort_order = '" . (int)$data['sort_order'] . "'";
		$this->db->query($sql);
	}

	public function editDegree($degree_id, $data) {
		$sql = "UPDATE " . DB_PREFIX . "degree SET degree_name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE degree_id = $degree_id";
		$this->db->query($sql);
	}

	public function deleteDegree($degree_id) {
		$sql = "UPDATE " . DB_PREFIX . "degree SET deleted = 1 WHERE degree_id = '" . (int)$degree_id . "'";
		$this->db->query($sql);
	}

	public function getDegree($degree_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "degree WHERE degree_id = $degree_id AND deleted = 0");

		return $query->row;
	} 

	public function getDegrees($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "degree WHERE deleted = 0";

		$sql .= " ORDER BY sort_order, degree_name COLLATE utf8_spanish_ci";

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

	public function getTotalDegrees() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "degree WHERE deleted = 0");

		return $query->row['total'];
	}
}
?>