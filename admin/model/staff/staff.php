<?php
class ModelStaffStaff extends Model {
	public function addStaff($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "staff SET firstname = '" . $this->db->escape(html_entity_decode($data['firstname'], ENT_QUOTES, 'UTF-8')) . "', middlename = '" . $this->db->escape(html_entity_decode($data['middlename'], ENT_QUOTES, 'UTF-8')) . "', lastname = '" . $this->db->escape(html_entity_decode($data['lastname'], ENT_QUOTES, 'UTF-8')) . "', staff_code = '" . $this->db->escape(html_entity_decode($data['code'], ENT_QUOTES, 'UTF-8')) . "', birthday = '" . $this->db->escape($data['birthday']) . "', salary = " . (int)$data['salary'] . ", salary_trial = " . (int)$data['salary_trial'] . ", department_id = '" . (int)$data['department_id'] . "', image = '" . $this->db->escape($data['image']) . "'";
		$this->db->query($sql);

		$staff_id = $this->db->getLastId();

		if ( isset($data['salaries']) ) {
			$sql = "SELECT * FROM " . DB_PREFIX . "salary WHERE staff_id = $staff_id AND deleted = 0";
			$query = $this->db->query($sql);
			$salaries = $query->rows;
			foreach ($salaries as $salary) {
				$sql = "UPDATE " . DB_PREFIX . "salary SET value = " . $data['salaries'][$salary['salary_type_id']] . " WHERE salary_id = " . $salary['salary_id'];
				$this->db->query($sql);
				unset($data['salaries'][$salary['salary_type_id']]);
			}
			foreach ($data['salaries'] as $salary_type_id => $value) {
				$sql = "INSERT INTO " . DB_PREFIX . "salary SET salary_type_id = $salary_type_id, staff_id = $staff_id, value = $value";
				$this->db->query($sql);
			}
		}
	}

	public function editStaff($staff_id, $data) {
		$sql = "UPDATE " . DB_PREFIX . "staff SET firstname = '" . $this->db->escape(html_entity_decode($data['firstname'], ENT_QUOTES, 'UTF-8')) . "', middlename = '" . $this->db->escape(html_entity_decode($data['middlename'], ENT_QUOTES, 'UTF-8')) . "', lastname = '" . $this->db->escape(html_entity_decode($data['lastname'], ENT_QUOTES, 'UTF-8')) . "', staff_code = '" . $this->db->escape(html_entity_decode($data['code'], ENT_QUOTES, 'UTF-8')) . "', birthday = '" . $this->db->escape($data['birthday']) . "', salary = " . (int)$data['salary'] . ", salary_trial = " . (int)$data['salary_trial'] . ", department_id = '" . (int)$data['department_id'] . "', image = '" . $this->db->escape($data['image']) . "' WHERE staff_id = '" . (int)$staff_id . "'";
		$this->db->query($sql);

		if ( isset($data['salaries']) ) {
			$sql = "SELECT * FROM " . DB_PREFIX . "salary WHERE staff_id = $staff_id AND deleted = 0";
			$query = $this->db->query($sql);
			$salaries = $query->rows;
			foreach ($salaries as $salary) {
				$sql = "UPDATE " . DB_PREFIX . "salary SET value = " . $data['salaries'][$salary['salary_type_id']] . " WHERE salary_id = " . $salary['salary_id'];
				$this->db->query($sql);
				unset($data['salaries'][$salary['salary_type_id']]);
			}
			foreach ($data['salaries'] as $salary_type_id => $value) {
				$sql = "INSERT INTO " . DB_PREFIX . "salary SET salary_type_id = $salary_type_id, staff_id = $staff_id, value = $value";
				$this->db->query($sql);
			}
		}
	}

	public function deleteStaff($staff_id) {
		$sql = "UPDATE " . DB_PREFIX . "staff SET deleted = 1 WHERE staff_id = " . (int)$staff_id;
		$this->db->query($sql);
	}

	public function getStaff($staff_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "staff st LEFT JOIN " . DB_PREFIX . "department dp ON st.department_id = dp.department_id AND dp.deleted = 0 WHERE st.staff_id = '$staff_id' AND st.deleted = 0");

		return $query->row;
	} 

	public function getStaffs($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "staff st LEFT JOIN " . DB_PREFIX . "department dp ON st.department_id = dp.department_id AND dp.deleted = 0 WHERE st.deleted = 0";

		if (!empty($data['filter_code'])) {
			$sql .= " AND st.staff_code LIKE '%" . $this->db->escape($data['filter_code']) . "%'";
		}

		if (!empty($data['filter_fullname'])) {
			$sql .= " AND (st.firstname LIKE '%" . $this->db->escape($data['filter_fullname']) . "%' OR st.middlename LIKE '%" . $this->db->escape($data['filter_fullname']) . "%' OR st.lastname LIKE '%" . $this->db->escape($data['filter_fullname']) . "%')";
		}

		if (!empty($data['filter_day'])) {
			$sql .= " AND DAY(st.birthday) = " . (int)$data['filter_day'];
		}

		if (!empty($data['filter_month'])) {
			$sql .= " AND MONTH(st.birthday) = " . (int)$data['filter_month'];
		}

		if (!empty($data['filter_year'])) {
			$sql .= " AND YEAR(st.birthday) = " . (int)$data['filter_year'];
		}

		if (!empty($data['filter_salary'])) {
			$sql .= " AND st.salary = " . (int)$data['filter_salary'];
		}

		if (!empty($data['filter_department_id'])) {
			$sql .= " AND st.department_id = " . (int)$data['filter_department_id'];
		}

		$sort_data = array(
			'st.staff_code',
			'st.lastname',
			'st.birthday',
			'st.salary'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY st.lastname";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
// print($sql);exit;
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalStaffs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "staff WHERE deleted = 0");

		return $query->row['total'];
	}

	public function getLastCode() {
		$sql = "SELECT * FROM " . DB_PREFIX . "staff ORDER BY staff_code DESC LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row['staff_code'];
	}
}
?>