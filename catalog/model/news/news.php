<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Bommer Luu
//Email (PayPal Account): lqthi.khtn@gmail.com
//License: OpenCart 2.0.x
?>
<?php
class ModelNewsNews extends Model {
	public function getNews($news_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1' ORDER BY n.sort_order ASC");
	
		return $query->row;
	}
	
	public function updateNewsReadCounter($news_id, $new_read_counter_value) {
	$this->db->query("UPDATE " . DB_PREFIX . "news SET count_read = '" . (int)$new_read_counter_value . "' WHERE news_id = '" . (int)$news_id . "'");
   }
   
   public function addComment($news_id, $name, $email, $comment, $comment_status) {
		$today_date = date("F j, Y, g:i a");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "news_comment SET news_id = '" . (int)$news_id . "', name = '" . $this->db->escape($name) . "', email = '" . $this->db->escape($email) . "', comment = '" . $this->db->escape(strip_tags($comment)) . "', status = '" . (int)$comment_status . "',  date_added = NOW()");
	}
	
	public function getCommentsByNewsId($news_id, $start = 0, $limit = 40) {
		$query = $this->db->query("SELECT nc.news_id, nc.name, nc.email, nc.comment, n.news_id, nd.title, n.image, nc.date_added FROM " . DB_PREFIX . "news_comment nc LEFT JOIN " . DB_PREFIX . "news n ON (nc.news_id = n.news_id) LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND n.status = '1' AND nc.status = '1' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY nc.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}
	
	public function getNewss($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id)";
		
		if (!empty($data['filter_news_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "news_to_category n2c ON (n.news_id = n2c.news_id)";			
		}
		
		if (!empty($data['filter_tag'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "news_tag nt ON (n.news_id = nt.news_id)";			
		}
		
		$sql .= " WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_news_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();
				
				$implode_data[] = "n2c.news_category_id = '" . (int)$data['filter_news_category_id'] . "'";
				
				$categories = $this->getCategoriesByParentId($data['filter_news_category_id']);
					
				foreach ($categories as $news_category_id) {
					$implode_data[] = "n2c.news_category_id = '" . (int)$news_category_id . "'";
				}
							
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND n2c.news_category_id = '" . (int)$data['filter_news_category_id'] . "'";
			}
		}	
		
		$sort_data = array(
			'nd.date_added',
			'nd.date_modified',
			'n.sort_order',
			'n.sort_order, nd.date_added',
			'n.sort_order, nd.date_modified',
		);		
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY n.sort_order, nd.date_added";	
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
		
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getTotalNews($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.news_id) AS total FROM " . DB_PREFIX . "news p LEFT JOIN " . DB_PREFIX . "news_description pd ON (p.news_id = pd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store p2s ON (p.news_id = p2s.news_id)";

		if (!empty($data['filter_news_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "news_to_category p2c ON (p.news_id = p2c.news_id)";			
		}
		
		if (!empty($data['filter_tag'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "news_tag pt ON (p.news_id = pt.news_id)";			
		}
					
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
		
		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";
								
			if (!empty($data['filter_name'])) {
				$implode = array();
				
				$words = explode(' ', $data['filter_name']);
				
				foreach ($words as $word) {
					if (!empty($data['filter_description'])) {
						$implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(pd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
					} else {
						$implode[] = "LCASE(pd.name) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
					}				
				}
				
				if ($implode) {
					$sql .= " " . implode(" OR ", $implode) . "";
				}
			}
			
			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}
			
			if (!empty($data['filter_tag'])) {
				$implode = array();
				
				$words = explode(' ', $data['filter_tag']);
				
				foreach ($words as $word) {
					$implode[] = "LCASE(pt.tag) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%' AND pt.language_id = '" . (int)$this->config->get('config_language_id') . "'";
				}
				
				if ($implode) {
					$sql .= " " . implode(" OR ", $implode) . "";
				}
			}
		
			$sql .= ")";
		}
		
		if (!empty($data['filter_news_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$implode_data = array();
				
				$implode_data[] = "p2c.news_category_id = '" . (int)$data['filter_news_category_id'] . "'";
				
				$categories = $this->getCategoriesByParentId($data['filter_news_category_id']);
					
				foreach ($categories as $news_category_id) {
					$implode_data[] = "p2c.news_category_id = '" . (int)$news_category_id . "'";
				}
							
				$sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
			} else {
				$sql .= " AND p2c.news_category_id = '" . (int)$data['filter_news_category_id'] . "'";
			}
		}	
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function getTotalCommentsByNewsId($news_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_comment nc LEFT JOIN " . DB_PREFIX . "news n ON (nc.news_id = n.news_id) LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND n.status = '1' AND nc.status = '1' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row['total'];
	}
	
	public function getRelatedNews($news_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) LEFT JOIN " . DB_PREFIX . "news_related nr ON (n.news_id = nr.child_news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1' AND n.sort_order <> '-1' AND nr.parent_news_id = '" . (int)$news_id. "' ORDER BY n.sort_order, nd.date_modified DESC");
		
		return $query->rows;
	}
	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_description cd ON (c.news_category_id = cd.news_category_id) LEFT JOIN " . DB_PREFIX . "news_category_to_store c2s ON (c.news_category_id = c2s.news_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
		
		return $query->rows;
	}
	
	public function getNewsCategory($news_category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_description cd ON (c.news_category_id = cd.news_category_id) LEFT JOIN " . DB_PREFIX . "news_category_to_store c2s ON (c.news_category_id = c2s.news_category_id) WHERE c.news_category_id = '" . (int)$news_category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		return $query->row;
	}
	
	public function getCategoriesByParentId($news_category_id) {
		$news_category_data = array();
		
		$news_category_query = $this->db->query("SELECT news_category_id FROM " . DB_PREFIX . "news_category WHERE parent_id = '" . (int)$news_category_id . "'");
		
		foreach ($news_category_query->rows as $news_category) {
			$news_category_data[] = $news_category['news_category_id'];
			
			$children = $this->getCategoriesByParentId($news_category['news_category_id']);
			
			if ($children) {
				$news_category_data = array_merge($children, $news_category_data);
			}			
		}
		
		return $news_category_data;
	}
		
	public function getNewsCategoryLayoutId($news_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category_to_layout WHERE news_category_id = '" . (int)$news_category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_news_category');
		}
	}
					
	public function getTotalCategoriesBynews_categoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_to_store c2s ON (c.news_category_id = c2s.news_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		return $query->row['total'];
	}	
}
?>
