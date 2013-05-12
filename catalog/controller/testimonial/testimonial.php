<?php
class ControllerTestimonialTestimonial extends Controller {
	public function index() {
		$this->language->load('testimonial/testimonial');

		$this->load->model('testimonial/testimonial');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home'),
			'separator'	=> false
		);

		$this->data['breadcrumbs'][] = array(
			'href'		=> $this->url->link('testimonial/testimonial'),
			'text'		=> $this->language->get('heading_title'),
			'separator'	=> $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['text_add'] = $this->language->get('text_add');
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['add'] = $this->url->link('testimonial/testimonial_form');
		$this->data['continue'] = $this->url->link('common/home');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$this->data['testimonials'] = array();

		$testimonial_total = $this->model_testimonial_testimonial->getTotalTestimonials();

		$results = $this->model_testimonial_testimonial->getTestimonials(($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));

		foreach ($results as $result) {
			$this->data['testimonials'][] = array(
				'name'			=> $result['name'],
				'location'		=> $result['location'],
				'url'			=> (strpos($result['url'], "http://") !== false) ? $result['url'] : 'http://' . $result['url'],
				'image'			=> $result['image'],
				'description'	=> html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				'rating'		=> $result['rating'],
				'date'			=> $result['date']
			);
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$pagination = new Pagination();
		$pagination->total = $testimonial_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_catalog_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('testimonial/testimonial') . $url . '&page={page}';

		$this->data['pagination'] = $pagination->render();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/testimonial/testimonial.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/testimonial/testimonial.tpl';
		} else {
			$this->template = 'default/template/testimonial/testimonial.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}
}
?>