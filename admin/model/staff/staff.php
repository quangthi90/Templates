<?php
class ModelStaffStaff extends Model {
	public function addStaff($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "staff SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$staff_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "staff SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE staff_id = '" . (int)$staff_id . "'");
		}

		foreach ($data['staff_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "staff_description SET staff_id = '" . (int)$staff_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "staff_path` WHERE staff_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "staff_path` SET `staff_id` = '" . (int)$staff_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "staff_path` SET `staff_id` = '" . (int)$staff_id . "', `path_id` = '" . (int)$staff_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['staff_filter'])) {
			foreach ($data['staff_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "staff_filter SET staff_id = '" . (int)$staff_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['staff_store'])) {
			foreach ($data['staff_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "staff_to_store SET staff_id = '" . (int)$staff_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this staff
		if (isset($data['staff_layout'])) {
			foreach ($data['staff_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "staff_to_layout SET staff_id = '" . (int)$staff_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'staff_id=" . (int)$staff_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('staff');
	}

	public function editstaff($staff_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "staff SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE staff_id = '" . (int)$staff_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "staff SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE staff_id = '" . (int)$staff_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "staff_description WHERE staff_id = '" . (int)$staff_id . "'");

		foreach ($data['staff_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "staff_description SET staff_id = '" . (int)$staff_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "staff_path` WHERE path_id = '" . (int)$staff_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $staff_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "staff_path` WHERE staff_id = '" . (int)$staff_path['staff_id'] . "' AND level < '" . (int)$staff_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "staff_path` WHERE staff_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "staff_path` WHERE staff_id = '" . (int)$staff_path['staff_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "staff_path` SET staff_id = '" . (int)$staff_path['staff_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "staff_path` WHERE staff_id = '" . (int)$staff_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "staff_path` WHERE staff_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "staff_path` SET staff_id = '" . (int)$staff_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "staff_path` SET staff_id = '" . (int)$staff_id . "', `path_id` = '" . (int)$staff_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "staff_filter WHERE staff_id = '" . (int)$staff_id . "'");

		if (isset($data['staff_filter'])) {
			foreach ($data['staff_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "staff_filter SET staff_id = '" . (int)$staff_id . "', filter_id = '" . (int)$filter_id . "'");
			}		
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "staff_to_store WHERE staff_id = '" . (int)$staff_id . "'");

		if (isset($data['staff_store'])) {		
			foreach ($data['staff_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "staff_to_store SET staff_id = '" . (int)$staff_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "staff_to_layout WHERE staff_id = '" . (int)$staff_id . "'");

		if (isset($data['staff_layout'])) {
			foreach ($data['staff_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "staff_to_layout SET staff_id = '" . (int)$staff_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'staff_id=" . (int)$staff_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'staff_id=" . (int)$staff_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('staff');
	}

	public function deletestaff($staff_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "staff_path WHERE staff_id = '" . (int)$staff_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "staff_path WHERE path_id = '" . (int)$staff_id . "'");

		foreach ($query->rows as $result) {	
			$this->deletestaff($result['staff_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "staff WHERE staff_id = '" . (int)$staff_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "staff_description WHERE staff_id = '" . (int)$staff_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "staff_filter WHERE staff_id = '" . (int)$staff_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "staff_to_store WHERE staff_id = '" . (int)$staff_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "staff_to_layout WHERE staff_id = '" . (int)$staff_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_staff WHERE staff_id = '" . (int)$staff_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'staff_id=" . (int)$staff_id . "'");

		$this->cache->delete('staff');
	}

	public function getStaff($staff_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "staff WHERE staff_id = '$staff_id' AND deleted = 0");

		return $query->row;
	} 

	public function getStaffs($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "staff WHERE deleted = 0";

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