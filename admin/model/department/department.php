<?php
class ModelDepartmentDepartment extends Model {
	public function addDepartment($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "department SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$department_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "department SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE department_id = '" . (int)$department_id . "'");
		}

		foreach ($data['department_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "department_description SET department_id = '" . (int)$department_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "department_path` WHERE department_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "department_path` SET `department_id` = '" . (int)$department_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "department_path` SET `department_id` = '" . (int)$department_id . "', `path_id` = '" . (int)$department_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['department_filter'])) {
			foreach ($data['department_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "department_filter SET department_id = '" . (int)$department_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['department_store'])) {
			foreach ($data['department_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "department_to_store SET department_id = '" . (int)$department_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this department
		if (isset($data['department_layout'])) {
			foreach ($data['department_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "department_to_layout SET department_id = '" . (int)$department_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'department_id=" . (int)$department_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('department');
	}

	public function editdepartment($department_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "department SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE department_id = '" . (int)$department_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "department SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE department_id = '" . (int)$department_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "department_description WHERE department_id = '" . (int)$department_id . "'");

		foreach ($data['department_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "department_description SET department_id = '" . (int)$department_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "department_path` WHERE path_id = '" . (int)$department_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $department_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "department_path` WHERE department_id = '" . (int)$department_path['department_id'] . "' AND level < '" . (int)$department_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "department_path` WHERE department_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "department_path` WHERE department_id = '" . (int)$department_path['department_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "department_path` SET department_id = '" . (int)$department_path['department_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "department_path` WHERE department_id = '" . (int)$department_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "department_path` WHERE department_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "department_path` SET department_id = '" . (int)$department_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "department_path` SET department_id = '" . (int)$department_id . "', `path_id` = '" . (int)$department_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "department_filter WHERE department_id = '" . (int)$department_id . "'");

		if (isset($data['department_filter'])) {
			foreach ($data['department_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "department_filter SET department_id = '" . (int)$department_id . "', filter_id = '" . (int)$filter_id . "'");
			}		
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "department_to_store WHERE department_id = '" . (int)$department_id . "'");

		if (isset($data['department_store'])) {		
			foreach ($data['department_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "department_to_store SET department_id = '" . (int)$department_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "department_to_layout WHERE department_id = '" . (int)$department_id . "'");

		if (isset($data['department_layout'])) {
			foreach ($data['department_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "department_to_layout SET department_id = '" . (int)$department_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'department_id=" . (int)$department_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'department_id=" . (int)$department_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('department');
	}

	public function deletedepartment($department_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "department_path WHERE department_id = '" . (int)$department_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "department_path WHERE path_id = '" . (int)$department_id . "'");

		foreach ($query->rows as $result) {	
			$this->deletedepartment($result['department_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "department WHERE department_id = '" . (int)$department_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "department_description WHERE department_id = '" . (int)$department_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "department_filter WHERE department_id = '" . (int)$department_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "department_to_store WHERE department_id = '" . (int)$department_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "department_to_layout WHERE department_id = '" . (int)$department_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_department WHERE department_id = '" . (int)$department_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'department_id=" . (int)$department_id . "'");

		$this->cache->delete('department');
	}

	public function getDepartment($department_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "department WHERE department_id = '$department_id'");

		return $query->row;
	} 

	public function getDepartments($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "department dp";

		$sql .= " ORDER BY dp.order";

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
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "department");

		return $query->row['total'];
	}
}
?>