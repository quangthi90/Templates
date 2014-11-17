<?php
class ModelSalaryType extends Model {
	public function addType($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "type SET name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', percent_of_salary = '" . (int)$data['percent'] . "', sort_order = '" . (int)$data['sort_order'] . "'";
		$this->db->query($sql);
	}

	public function editType($type_id, $data) {
		$sql = "UPDATE " . DB_PREFIX . "salary_type SET name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', percent_of_salary = '" . (int)$data['percent'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE salary_type_id = $type_id";
		$this->db->query($sql);
	}

	public function deleteType($type_id) {
		$sql = "UPDATE " . DB_PREFIX . "salary_type SET deleted = 1 WHERE salary_type_id = '" . (int)$type_id . "'";
		$this->db->query($sql);
	}

	public function getType($type_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salary_type WHERE salary_type_id = $type_id AND deleted = 0");

		return $query->row;
	} 

	public function getTypes($data = array()) {
		$sql = "SELECT st.salary_type_id, st.name, st.percent_of_salary, st.sort_order, st.deleted, sl.value FROM " . DB_PREFIX . "salary_type st LEFT JOIN " . DB_PREFIX . "salary sl ON sl.salary_type_id = st.salary_type_id AND sl.deleted = 0";

		if (!empty($data['staff_id'])) {
			$sql .= " AND sl.staff_id = " . (int)$data['staff_id'];
		}

		$sql .= " WHERE st.deleted = 0";

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

	public function getTotalTypes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salary_type WHERE deleted = 0");

		return $query->row['total'];
	}	

	public function getTotaltypesByImageId($image_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "type WHERE image_id = '" . (int)$image_id . "'");

		return $query->row['total'];
	}

	public function getTotaltypesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "type_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}		
}
?>