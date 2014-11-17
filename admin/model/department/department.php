<?php
class ModelDepartmentDepartment extends Model {
	public function addDepartment($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "department SET name = '" . $this->db->escape($data['name']) . "', department_code = '" . $this->db->escape($data['code']) . "', sort_order = " . (int)$data['order'];
		$this->db->query($sql);
	}

	public function editDepartment($department_id, $data) {
		$sql = "UPDATE " . DB_PREFIX . "department SET name = '" . $this->db->escape($data['name']) . "', department_code = '" . $this->db->escape($data['code']) . "', sort_order = " . (int)$data['order'] . " WHERE department_id = '" . (int)$department_id . "'";
		$this->db->query($sql);
	}

	public function deleteDepartment($department_id) {
		$sql = "UPDATE " . DB_PREFIX . "department SET deleted = 1 WHERE department_id = '" . (int)$department_id . "'";
		$this->db->query($sql);
	}

	/*public function deleteDepartment($department_id) {
		$sql = "DELETE FROM " . DB_PREFIX . "department WHERE department_id = '" . (int)$department_id . "'";
		$this->db->query($sql);
	}*/

	public function getDepartment($department_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "department WHERE department_id = '$department_id' AND deleted = 0";

		$query = $this->db->query($sql);

		return $query->row;
	} 

	public function getDepartments($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "department WHERE deleted = 0";

		$sql .= " ORDER BY sort_order";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotaldepartments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "department WHERE deleted = 0");

		return $query->row['total'];
	}
}
?>