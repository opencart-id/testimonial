<?php
class ModelTestimonialTestimonial extends Model {
    public function addTestimonial($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "testimonial SET name = '" . $this->db->escape($data['name']) . "', location = '" . $this->db->escape($data['location']) . "', url = '" . $this->db->escape($data['url']) . "', image = '" . $this->db->escape(html_entity_decode('data/testimonial/' . $data['image'], ENT_QUOTES, 'UTF-8')) . "', description = '" . $this->db->escape($data['description']) . "', rating = '" . (int)$this->request->post['rating'] . "', date = NOW()");
    }

    public function getTestimonial($testimonial_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "testimonial WHERE testimonial_id = '" . (int)$testimonial_id . "' AND status = '1'");

        return $query->row;
    }

    public function getTestimonials($start = 0, $limit = 20) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "testimonial WHERE status = '1' ORDER BY sort_order ASC, date DESC LIMIT " . (int)$start . "," . (int)$limit);

        return $query->rows;
    }

    public function getTotalTestimonials() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "testimonial WHERE status = '1'");

        return $query->row['total'];
    }
}
?>