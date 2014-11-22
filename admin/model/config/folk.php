<?php
class ModelConfigFolk extends Model {
	public function addFolk($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "folk SET folk_name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', sort_order = '" . (int)$data['sort_order'] . "'";
		$this->db->query($sql);
	}

	public function editFolk($folk_id, $data) {
		$sql = "UPDATE " . DB_PREFIX . "folk SET folk_name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE folk_id = $folk_id";
		$this->db->query($sql);
	}

	public function deleteFolk($folk_id) {
		$sql = "UPDATE " . DB_PREFIX . "folk SET deleted = 1 WHERE folk_id = '" . (int)$folk_id . "'";
		$this->db->query($sql);
	}

	public function getFolk($folk_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "folk WHERE folk_id = $folk_id AND deleted = 0");

		return $query->row;
	} 

	public function getFolks($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "folk WHERE deleted = 0";

		$sql .= " ORDER BY sort_order, folk_name COLLATE utf8_spanish_ci";

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

	public function getTotalFolks() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "folk WHERE deleted = 0");

		return $query->row['total'];
	}
}
?>