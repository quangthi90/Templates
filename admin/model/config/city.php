<?php
class ModelConfigCity extends Model {
	public function addCity($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "city SET city_name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', sort_order = '" . (int)$data['sort_order'] . "'";
		$this->db->query($sql);
	}

	public function editCity($city_id, $data) {
		$sql = "UPDATE " . DB_PREFIX . "city SET city_name = '" . $this->db->escape(html_entity_decode($data['name'])) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE city_id = $city_id";
		$this->db->query($sql);
	}

	public function deleteCity($city_id) {
		$sql = "UPDATE " . DB_PREFIX . "city SET deleted = 1 WHERE city_id = '" . (int)$city_id . "'";
		$this->db->query($sql);
	}

	public function getCity($city_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city WHERE city_id = $city_id AND deleted = 0");

		return $query->row;
	} 

	public function getCities($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "city WHERE deleted = 0";

		$sql .= " ORDER BY sort_order, city_name COLLATE utf8_spanish_ci";

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

	public function getTotalCities() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "city WHERE deleted = 0");

		return $query->row['total'];
	}
}
?>