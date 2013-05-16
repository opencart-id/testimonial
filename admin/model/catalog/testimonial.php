<?php
class ModelCatalogTestimonial extends Model {
	public function checkDatabase() {
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "testimonial'");

		if (!$query->num_rows) {
			$this->db->query("CREATE TABLE `" . DB_PREFIX . "testimonial` (`testimonial_id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(64) NOT NULL, `location` varchar(64) NOT NULL, `url` varchar(128) NOT NULL, `image` varchar(255) DEFAULT NULL, `description` text NOT NULL, `rating` int(1) NOT NULL, `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', `status` tinyint(1) NOT NULL, `sort_order` int(3) NOT NULL DEFAULT '0', PRIMARY KEY (`testimonial_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
		}
	}

	public function addTestimonial($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "testimonial SET name = '" . $this->db->escape($data['name']) . "', location = '" . $this->db->escape($data['location']) . "', url = '" . $this->db->escape($data['url']) . "', description = '" . $this->db->escape($data['description']) . "', date = NOW(), status = '" . (int)$this->request->post['status'] . "', sort_order = '" . (int)$this->request->post['sort_order'] . "'");

		$testimonial_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}

		if (isset($data['rating'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET rating = '" . (int)$this->request->post['rating'] . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}

		$this->cache->delete('testimonial');
	}

	public function editTestimonial($testimonial_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET name = '" . $this->db->escape($data['name']) . "', location = '" . $this->db->escape($data['location']) . "', url = '" . $this->db->escape($data['url']) . "', description = '" . $this->db->escape($data['description']) . "', status = '" . (int)$this->request->post['status'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}

		if (isset($data['rating'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "testimonial SET rating = '" . (int)$this->request->post['rating'] . "' WHERE testimonial_id = '" . (int)$testimonial_id . "'");
		}

		$this->cache->delete('testimonial');
	}

	public function deleteTestimonial($testimonial_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "testimonial WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		$this->cache->delete('testimonial');
	}

	public function getTestimonial($testimonial_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "testimonial WHERE testimonial_id = '" . (int)$testimonial_id . "'");

		return $query->row;
	}

	public function getTestimonials($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "testimonial ";

			$sort_data = array(
				'testimonial_id',
				'name',
				'sort_order',
				'status'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY testimonial_id";
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
		} else {
			$testimonial_data = $this->cache->get('testimonial.');

			if (!$testimonial_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial ORDER BY testimonial_id");

				$testimonial_data = $query->rows;

				$this->cache->set('testimonial.', $testimonial_data);
			}

			return $testimonial_data;
		}
	}

	public function getTotalTestimonials() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "testimonial");

		return $query->row['total'];
	}
}
?>