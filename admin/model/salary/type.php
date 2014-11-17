<?php
class ModelSalaryType extends Model {
	public function addtype($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "type SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$type_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "type SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE type_id = '" . (int)$type_id . "'");
		}

		foreach ($data['type_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "type_description SET type_id = '" . (int)$type_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "type_path` WHERE type_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "type_path` SET `type_id` = '" . (int)$type_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "type_path` SET `type_id` = '" . (int)$type_id . "', `path_id` = '" . (int)$type_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['type_filter'])) {
			foreach ($data['type_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "type_filter SET type_id = '" . (int)$type_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['type_store'])) {
			foreach ($data['type_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "type_to_store SET type_id = '" . (int)$type_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this type
		if (isset($data['type_layout'])) {
			foreach ($data['type_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "type_to_layout SET type_id = '" . (int)$type_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'type_id=" . (int)$type_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('type');
	}

	public function edittype($type_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "type SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE type_id = '" . (int)$type_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "type SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE type_id = '" . (int)$type_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "type_description WHERE type_id = '" . (int)$type_id . "'");

		foreach ($data['type_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "type_description SET type_id = '" . (int)$type_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "type_path` WHERE path_id = '" . (int)$type_id . "' ORDER BY level ASC");

		if ($query->rows) {
			foreach ($query->rows as $type_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "type_path` WHERE type_id = '" . (int)$type_path['type_id'] . "' AND level < '" . (int)$type_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "type_path` WHERE type_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "type_path` WHERE type_id = '" . (int)$type_path['type_id'] . "' ORDER BY level ASC");

				foreach ($query->rows as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "type_path` SET type_id = '" . (int)$type_path['type_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "type_path` WHERE type_id = '" . (int)$type_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "type_path` WHERE type_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "type_path` SET type_id = '" . (int)$type_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "type_path` SET type_id = '" . (int)$type_id . "', `path_id` = '" . (int)$type_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "type_filter WHERE type_id = '" . (int)$type_id . "'");

		if (isset($data['type_filter'])) {
			foreach ($data['type_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "type_filter SET type_id = '" . (int)$type_id . "', filter_id = '" . (int)$filter_id . "'");
			}		
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "type_to_store WHERE type_id = '" . (int)$type_id . "'");

		if (isset($data['type_store'])) {		
			foreach ($data['type_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "type_to_store SET type_id = '" . (int)$type_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "type_to_layout WHERE type_id = '" . (int)$type_id . "'");

		if (isset($data['type_layout'])) {
			foreach ($data['type_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "type_to_layout SET type_id = '" . (int)$type_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'type_id=" . (int)$type_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'type_id=" . (int)$type_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('type');
	}

	public function deletetype($type_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "type_path WHERE type_id = '" . (int)$type_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "type_path WHERE path_id = '" . (int)$type_id . "'");

		foreach ($query->rows as $result) {	
			$this->deletetype($result['type_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "type WHERE type_id = '" . (int)$type_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "type_description WHERE type_id = '" . (int)$type_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "type_filter WHERE type_id = '" . (int)$type_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "type_to_store WHERE type_id = '" . (int)$type_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "type_to_layout WHERE type_id = '" . (int)$type_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_type WHERE type_id = '" . (int)$type_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'type_id=" . (int)$type_id . "'");

		$this->cache->delete('type');
	} 

	// Function to repair any erroneous types that are not in the type path table.
	public function repairtypes($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "type WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->rows as $type) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "type_path` WHERE type_id = '" . (int)$type['type_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "type_path` WHERE type_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "type_path` SET type_id = '" . (int)$type['type_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "type_path` SET type_id = '" . (int)$type['type_id'] . "', `path_id` = '" . (int)$type['type_id'] . "', level = '" . (int)$level . "'");

			$this->repairtypes($type['type_id']);
		}
	}

	public function gettype($type_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR ' &gt; ') FROM " . DB_PREFIX . "type_path cp LEFT JOIN " . DB_PREFIX . "type_description cd1 ON (cp.path_id = cd1.type_id AND cp.type_id != cp.path_id) WHERE cp.type_id = c.type_id AND cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.type_id) AS path, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'type_id=" . (int)$type_id . "') AS keyword FROM " . DB_PREFIX . "type c LEFT JOIN " . DB_PREFIX . "type_description cd2 ON (c.type_id = cd2.type_id) WHERE c.type_id = '" . (int)$type_id . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	} 

	public function getTypes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "salary_type";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

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
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salary_type");

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