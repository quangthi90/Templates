<?php
class ModelStaffStaff extends Model {
	public function addStaff($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "staff SET firstname = '" . $this->db->escape(html_entity_decode($data['firstname'], ENT_QUOTES, 'UTF-8')) . "', middlename = '" . $this->db->escape(html_entity_decode($data['middlename'], ENT_QUOTES, 'UTF-8')) . "', lastname = '" . $this->db->escape(html_entity_decode($data['lastname'], ENT_QUOTES, 'UTF-8')) . "', staff_code = '" . $this->db->escape(html_entity_decode($data['code'], ENT_QUOTES, 'UTF-8')) . "', birthday = '" . $this->db->escape($data['birthday']) . "', salary = " . (int)$data['salary'] . ", department_id = '" . (int)$data['department_id'] . "', image = '" . $this->db->escape($data['image']) . "'";
		$this->db->query($sql);
	}

	public function editstaff($staff_id, $data) {
		// var_dump($data); exit;
		$sql = "UPDATE " . DB_PREFIX . "staff SET firstname = '" . $this->db->escape(html_entity_decode($data['firstname'], ENT_QUOTES, 'UTF-8')) . "', middlename = '" . $this->db->escape(html_entity_decode($data['middlename'], ENT_QUOTES, 'UTF-8')) . "', lastname = '" . $this->db->escape(html_entity_decode($data['lastname'], ENT_QUOTES, 'UTF-8')) . "', staff_code = '" . $this->db->escape(html_entity_decode($data['code'], ENT_QUOTES, 'UTF-8')) . "', birthday = '" . $this->db->escape($data['birthday']) . "', salary = " . (int)$data['salary'] . ", department_id = '" . (int)$data['department_id'] . "', image = '" . $this->db->escape($data['image']) . "' WHERE staff_id = '" . (int)$staff_id . "'";
		$this->db->query($sql);
	}

	public function deletestaff($staff_id) {
		$sql = "UPDATE " . DB_PREFIX . "staff SET deleted = 1 WHERE staff_id = " . (int)$staff_id;
		$this->db->query($sql);
	}

	public function getStaff($staff_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "staff st LEFT JOIN " . DB_PREFIX . "department dp ON st.department_id = dp.department_id AND dp.deleted = 0 WHERE st.staff_id = '$staff_id' AND st.deleted = 0");

		return $query->row;
	} 

	public function getStaffs($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "staff st LEFT JOIN " . DB_PREFIX . "department dp ON st.department_id = dp.department_id AND dp.deleted = 0 WHERE st.deleted = 0";

		$sql .= " ORDER BY 'lastname'";

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

	public function getTotalStaffs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "staff WHERE deleted = 0");

		return $query->row['total'];
	}
}
?>