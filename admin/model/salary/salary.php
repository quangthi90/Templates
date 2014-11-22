<?php
class ModelSalarySalary extends Model {
	public function addsalary($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "salary SET name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', percent_of_salary = '" . (int)$data['percent'] . "', sort_order = '" . (int)$data['sort_order'] . "'";
		$this->db->query($sql);
	}

	public function editsalary($salary_id, $data) {
		$sql = "UPDATE " . DB_PREFIX . "salary_salary SET name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', percent_of_salary = '" . (int)$data['percent'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE salary_salary_id = $salary_id";
		$this->db->query($sql);
	}

	public function deletesalary($salary_id) {
		$sql = "UPDATE " . DB_PREFIX . "salary_salary SET deleted = 1 WHERE salary_salary_id = '" . (int)$salary_id . "'";
		$this->db->query($sql);
	}

	public function getsalary($salary_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salary_salary WHERE salary_salary_id = $salary_id AND deleted = 0");

		return $query->row;
	} 

	public function getSalaries($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "salary sl WHERE sl.deleted = 0";

		if (!empty($data['staff_id'])) {
			$sql .= " AND sl.staff_id = " . (int)$data['staff_id'];
		} else {
			$sql .= " AND sl.staff_id = 0";
		}

		$query = $this->db->query($sql);

		$results = $query->rows;

		$salaries = array();
		foreach ($results as $result) {
			$salaries[$result['salary_type_id']] = $result;
		}

		return $salaries;
	}

	public function getTotalsalarys() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salary_salary WHERE deleted = 0");

		return $query->row['total'];
	}
}
?>